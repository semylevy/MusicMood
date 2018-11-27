import face_recognition
import sys
import json
import os

known_path = "./../known_people/"

# Load the data that PHP sent us
try:
  data = json.loads(sys.argv[1])
except:
  print ("ERROR")
  sys.exit(1)

directory = os.fsencode(known_path)
filenames = []
known_faces = []

for file in os.listdir(directory):
  filename = os.fsdecode(file)
  if not filename.startswith("."):
    filenames.append(filename)
    new_face = face_recognition.load_image_file(known_path + filename)
    known_faces.append(new_face)

known_encodings = []

for face in known_faces:
  try:
    known_encodings.append(face_recognition.face_encodings(face)[0])
  except IndexError:
    print ("Could not find face in picture")

unknown_path = data["path"]

unknown_image = face_recognition.load_image_file(unknown_path)

try:
  unknown_face_encoding = face_recognition.face_encodings(unknown_image)[0]
except IndexError:
  print("I wasn't able to locate any faces in at least one of the images. Check the image files. Aborting...")
  quit()

results = face_recognition.compare_faces(known_encodings, unknown_face_encoding)

count = 0
found_id = 0
for result in results:
  if result:
    found_id = filenames[count].split(".")[0]
  count = count + 1

# Generate some data to send to PHP
result = {'result': found_id}

# Send it to stdout (to PHP)
print (json.dumps(result))