import RPi.GPIO as GPIO
import dht11
import Adafruit_BMP.BMP085 as BMP085
import time
import datetime
from sklearn.neighbors import KNeighborsClassifier

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
		print("[Last valid input: " + str(datetime.datetime.now()) + "]")
		#X = [[(float)(result.temperature)],[(float)(sensor.read_temperature())],[(float)(result.humidity)],[(float)(sensor.read_altitude())],[(float)(sensor.read_pressure())]]
		X = [[21.3],[16.4],[15.8],[47.8],[50.9],[44.7],[100660.1],[100381.2],[100401.4],[55.7],[56.2],[54.9]]
		y = [1,1,1,2,2,2,3,3,3,4,4,4]
		print("Temp(DHT11):", (float)(result.temperature))
		print("Temp(BMP180):", (float)(sensor.read_temperature()))
		print("Hum(DHT11):", (float)(result.humidity))
		print("Alt(BMP180):", (float)(sensor.read_altitude()))
		print("BaroPre(BMP180):", (float)(sensor.read_pressure()))
		print("\n")
		neigh = KNeighborsClassifier(n_neighbors=3)
		neigh.fit(X, y)
		print(neigh.predict([[51.8]]))
		print(neigh.predict_proba([[51.8]]))
except KeyboardInterrupt:
    print("Cleanup")
    GPIO.cleanup()
