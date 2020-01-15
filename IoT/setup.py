# coding: utf-8
import smbus
import requests
import json
import sys
import time
from datetime import datetime

print("********** Please run with python3 **********")

path = './sensor.data'

#Input Check
if len(sys.argv) != 2:
  print("usage: python setup.py [num_of_sensor_or_db]")
  print(" num of dsensor or db : 1～5")
  exit(1)

#Get number
dbs = int(sys.argv[1]) # number of databases and sensor types
if 1 > dbs:
  print(" num of db and sensor : 1～")
  exit(1)

#Input information
count = [0] * 6
count[0] = -1
for i in range(1, dbs+1, 1):
  print("\nSensor type :")
  print("########################################")
  print("[1] temperature\n[2] humidity\n[3] altitude\n[4] Barometric pressure\n[5] others")
  print("########################################")
  print("Input sensor "+str(i)+" number >> ", end="")
  data = int(input())
  if data == 1:
    count[1] += 1
  elif data == 2:
    count[2] += 1
  elif data == 3:
    count[3] += 1
  elif data == 4:
    count[4] += 1
  else:
    count[5] += 1
#calc
name = [""]
name.append('temp\n')
name.append('hum\n')
name.append('alt\n')
name.append('pres\n')
name.append('other\n')
for i in range(1, 5, 1):
  for j in range(i+1, 6, 1):
    if count[i] < count[j]:
      tmp = count[i]
      count[i] = count[j]
      count[j] = tmp
      tmp = name[i]
      name[i] = name[j]
      name[j] = tmp

#write data
ct = 0
for i in range(1, 6, 1):
  if count[i] > 0:
    ct += 1
wd = []
for i in range(1, ct+1, 1):
  wd.append(name[i])

with open(path, mode='w') as f:
  f.writelines(wd)
