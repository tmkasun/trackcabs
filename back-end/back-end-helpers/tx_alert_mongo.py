from pymongo import MongoClient
from twisted.internet.defer import inlineCallbacks
from twisted.web.resource import Resource
from twisted.web.server import Site
from twisted.internet import reactor

import cgi

import serial
import time
import json
# Good article http://pedrokroger.net/getting-started-pycharm-python-ide/

# client = MongoClient() #will connect on the default host and port.
# We can also specify the host and port explicitly, as
# follows.
# Or use the MongoDB URI format
client = MongoClient('localhost', 27017)

debugObject = None


class AlertToMongo(Resource):
    isLeaf = True

    def render_GET(self, request):
        print "Got a GET request from {}".format(request.getClientIP())
        return "<html><body><p>Not a valid request</p></body></html>"

    def render_POST(self, request):
        print "Got a POST request from {}".format(request.getClientIP())

        requestContent = request.content.getvalue()
        jsonContent = json.loads(requestContent)

        print("Request content {}".format(jsonContent))

        result = self.updateAlert(jsonContent)

        return ""

    def updateAlert(self, jsonHash, collection='live'):
        return client.track[collection].update({'refId': int(jsonHash['properties']['orderId'])},
                                               {'$set': {'status': str(jsonHash['properties']['state'])}}, #"lastUpdatedOn": datetime.datetime.utcnow()
                                               upsert=False, multi=False)


port = 9091

root = Resource()
root.putChild('alert_mongo', AlertToMongo())
site = Site(root)
print "Starting server on {}".format(port)

reactor.listenTCP(port, site)
reactor.run()
