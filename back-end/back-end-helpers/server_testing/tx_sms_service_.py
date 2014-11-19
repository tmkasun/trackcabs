from twisted.internet.task import deferLater
from twisted.internet.defer import inlineCallbacks
from twisted.web.server import Site, NOT_DONE_YET
from twisted.internet import reactor
import cgi

import serial
import time
from twisted.web.resource import Resource


class TextMessage:
    def __init__(self, recipient="0711661919", message="Testing message from Kasun"):
        self.recipient = recipient
        self.content = message

    def setRecipient(self, number):
        self.recipient = number

    def setContent(self, message):
        self.content = message

    def connectPhone(self):
        self.ser = serial.Serial('/dev/ttyUSB0', 460800, timeout=5)
        time.sleep(1)

    def delayTime(self, seconds=1):
        time.sleep(seconds)

    def sendMessage(self):
        print "Sending SMS....."

        self.ser.write('ATZ\r')
        self.delayTime()

        self.ser.write('AT+CMGF=1\r')
        self.delayTime()

        self.ser.write('''AT+CMGS="''' + self.recipient + '''"\r''')
        self.delayTime()

        self.ser.write(self.content + "\r")
        self.delayTime()

        self.ser.write(chr(26))
        self.delayTime()

        print "Done. You should have receive the message by now!"

    def disconnectPhone(self):
        self.ser.close()


debugObject = None


class Simple(Resource):
    isLeaf = True

    def _delayedRender(self, request):
        mobile_number = request.args['mobile_number'][0]
        if not (self.isMobile(mobile_number)):
            return "Invalid mobile number: {}\nerror code:-1".format(mobile_number)
        message = request.args['message'][0]
        msg_gateway.setContent(message)
        msg_gateway.setRecipient(mobile_number)
        if not mode_flag == 1:
            msg_gateway.sendMessage()

    def render_GET(self, request):
        # reactor.callLater(2, reactor.stop)
        print "Got a GET request from {}".format(request.getClientIP())
        return "<html><body><p>REST SMS service</p>Params are <b>mobile_number</b> and <b>message</b></body></html>"

    def render_POST(self, request):
        print "Got POST a request from {}".format(request.getClientIP())
        global debugObject
        # reactor.callLater(2,reactor.stop)
        debugObject = request
        print(request.args)

        # TODO: Return JSON with status and ACK of sending message
        # TODO: Use inline call back ratherthan blocking call
        d = deferLater(reactor, 0, lambda: request)
        d.addCallback(self._delayedRender)
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

mode_flag_file = open("debug_mode", "r")
mode_flag = int(mode_flag_file.readline())

root = Resource()
root.putChild('sms_service', Simple())
site = Site(root)

print "Starting server on {}".format(port)
msg_gateway = TextMessage()
if not mode_flag == 1:
    msg_gateway.connectPhone()
    print "Connecting to phone on {}".format(msg_gateway.ser)
else:
    print("DEBUG_MODE enabled no message will be sent out from the dongle")

reactor.listenTCP(port, site)
reactor.run()
