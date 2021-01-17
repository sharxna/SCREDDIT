from imageai.Detection import ObjectDetection
import os
import mysql.connector
from mysql.connector import Error
from datetime import datetime, time
from pprint import pprint

execution_path = os.getcwd()

detector = ObjectDetection()
detector.setModelTypeAsRetinaNet()
detector.setModelPath( os.path.join(execution_path , "resnet50_coco_best_v2.1.0.h5"))
detector.loadModel()

def is_time_between(begin_time, end_time, check_time=None):
    # If check time is not given, default to current UTC time
    check_time = check_time or datetime.utcnow().time()
    if begin_time < end_time:
        #if check_time >= begin_time:
        #    print("1")
        #if check_time <= end_time:
        #    print("2")
        return check_time >= begin_time and check_time <= end_time
    else: # crosses midnight
        return check_time >= begin_time or check_time <= end_time



while True:
    files = os.listdir("SCSPhotos")
    
    for file in files:
        id = file.split(".")[0]
        outputFile = "SCSPhotos/new" + file
        if "detection" in file or "new" in file or "big" in file:
            continue
    
        print("|" + file + "|")
        if os.path.isfile("SCSPhotos/" + file + ".result"):
            print("found")
        else:
            connection = mysql.connector.connect(host='192.168.2.200',
                                         database='SCS',
                                         user='youri',
                                         password='Scorpion6*')
            sql_select_Query = "SELECT * FROM SCS.Answer as a JOIN SCS.Task as t on a.Task_id = t.id where a.id = " + id
            cursor = connection.cursor(dictionary=True)
            cursor.execute(sql_select_Query)
            records = cursor.fetchall()
            input_type = records[0]["input_type"]
            f = '%H:%M:%S'
            #pprint(records)
            
            if input_type == 3:
                fromTime = datetime.strptime(records[0]["from_time"], f)
                toTime = datetime.strptime(records[0]["to_time"], f)
                nowTime = datetime.strptime(datetime.now().strftime(f), f)
                pprint(fromTime)
                pprint(toTime)
                pprint(nowTime)
                if is_time_between(fromTime, toTime, nowTime):
                    print("timestamp OK")
                else:
                    os.system("rm " + "SCSPhotos/" + file)
                    sql_select_Query = "update SCS.Answer SET waiting = 0 WHERE id = " + id
                    cursor.execute(sql_select_Query)
                    connection.commit()
                    continue
                
            
            
            
            #os.system("touch " + "SCSPhotos/" + file + ".result")
            detections = detector.detectObjectsFromImage(input_image="SCSPhotos/" + file, output_image_path=outputFile)

            #os.system("rm " + "SCSPhotos/" + file + ".result")
            #with open("SCSPhotos/" + file + ".result", "w") as outfile:
            
            for eachObject in detections:
                print(eachObject["name"] , " : " , eachObject["percentage_probability"] )
                #outfile.write(eachObject["name"])
                if eachObject["name"] in records[0]["correct_answer"]:
                    sql_select_Query = "update SCS.Answer SET accepted = 1, waiting = 0 WHERE id = " + id
                    print(sql_select_Query)
                    cursor.execute(sql_select_Query)
                    connection.commit()
                
            #from IPython.display import Image
            #Image(filename=outputFile) 
            sql_select_Query = "update SCS.Answer SET waiting = 0 WHERE id = " + id
            cursor.execute(sql_select_Query)
            connection.commit()
            os.system("rm " + "SCSPhotos/" + file)
            
            
            

    
