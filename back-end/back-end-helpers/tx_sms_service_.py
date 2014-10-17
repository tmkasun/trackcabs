from twisted.web import server, resource
from twisted.internet import reactor

import cgi

import serial
import time


class TextMessage:
    def __init__(self, recipient="0711661919", message="Testing message from Kasun"):
        self.recipient = recipient
        self.content = message

    def setRecipient(self, number):
        self.recipient = number

    def setContent(self, message):
        self.content = message

    def connectPhone(self):
        self.ser = serial.Serial('/dev/ttyUSB_utps_modem', 460800, timeout=5)
        time.sleep(1)

    def sendMessage(self):
        print "Sending SMS....."
        self.ser.write('ATZ\r')
        time.sleep(1)
        self.ser.write('AT+CMGF=1\r')
        time.sleep(1)
        self.ser.write('''AT+CMGS="''' + self.recipient + '''"\r''')
        time.sleep(1)
        self.ser.write(self.content + "\r")
        time.sleep(1)
        self.ser.write(chr(26))
        time.sleep(1)
        print "Done. You should have receive the message by now!"

    def disconnectPhone(self):
        self.ser.close()


debugObject = None


class Simple(resource.Resource):
    isLeaf = True

    def render_GET(self, request):
        reactor.callLater(2, reactor.stop)
        return "<html><body><p>REST SMS service</p>Params are <b>mobile_number</b> and <b>message</b></body></html>"

    def render_POST(self, request):
        global debugObject
        # reactor.callLater(2,reactor.stop)
        debugObject = request
        mobile_number = request.args['mobile_number'][0]
        if not (self.isMobile(mobile_number)):
            return "Invalid mobile number: {}\nerror code:-1".format(mobile_number)
        message = request.args['message'][0]
        msg_gateway.setContent(message)
        msg_gateway.setRecipient(mobile_number)
        msg_gateway.sendMessage()
        return """<html>
            <body>
            You are connected from(IP): {}
            Arguments are: {}
            </body>
         </html>""".format(request.getClientIP(), request.args)

    def isMobile(self, number):
        try:
            int(number)
            if (len(number) != 10):
                return False
            return True
        except ValueError:
            return False


port = 3000
site = server.Site(Simple())
print "Starting server on {}".format(port)
msg_gateway = TextMessage()
msg_gateway.connectPhone()
print "Connecting to phone on {}".format(msg_gateway.ser)
reactor.listenTCP(port, site)
reactor.run()
