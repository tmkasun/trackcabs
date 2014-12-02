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

        request_content = request.content.getvalue()
        json_content = json.loads(request_content)

        print("Request content {}".format(json_content))

        result = self.update_alert(json_content)

        print(result)

        return ""

    def update_alert(self, jsonHash, collection='live'):
        order_state = str(jsonHash['properties']['state'])
        order_id = int(jsonHash['properties']['orderId'])

        print(
            "DEBUG: orderId = {} orderState = {}".format(order_id,
                                                         order_state))  # client.track['users'].update() #TODO: update cab status as-well

        client.track[collection].update({'refId': order_id}, {'$set': {'status': order_state}},
                                        # "lastUpdatedOn": datetime.datetime.utcnow()
                                        upsert=False, multi=False)
        if order_state == "IDLE":
            current_order = client.track[collection].find_one({'refId': order_id})
            client.track['history'].save(current_order)
            client.track[collection].remove({'refId': order_id})


port = 9091

root = Resource()
root.putChild('alert_mongo', AlertToMongo())
site = Site(root)
print "Starting server on {}".format(port)

reactor.listenTCP(port, site)
reactor.run()
