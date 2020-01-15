import RPi.GPIO as GPIO
import dht11
import Adafruit_BMP.BMP085 as BMP085
import requests
import json
import time
import datetime

# url address(GCP)
url = '[クラウド送信先URL]'

# initialize GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)

# initialize BMP085
sensor = BMP085.BMP085()

# read data using pin 14
instance = dht11.DHT11(pin=14)

try:
	result = instance.read()
	if result.is_valid():
		# Get sensor data
		data = []
		print("[Last valid input: " + str(datetime.datetime.now()) + "]")
		data.append(result.temperature)
		data.append(sensor.read_temperature())
                data.append(result.humidity)
                data.append(sensor.read_altitude())
                data.append(sensor.read_pressure())
		# Init name data
		name = []
		name.append('temp')
		name.append('temp')
		name.append('humid')
		name.append('alt')
		name.append('pres')
		# Send data
        	for i in range(len(data)):
			send_data = {'datetime':datetime.datetime.now().strftime("%Y/%m/%d %H:%M:%S"),name[i]:data[i]}
			print(json.dumps(send_data))
			response = requests.post(url, json.dumps(send_data), headers={'Content-type': 'application/json'})
			print(response.json())
			time.sleep(1)
	pass
except KeyboardInterrupt:
	print("Cleanup")
	GPIO.cleanup()
