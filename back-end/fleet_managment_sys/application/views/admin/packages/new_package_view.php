<form role="form" id="createDispatcher">
    <div class="form-group">
        <label for="name">Package Name</label>
        <input type="text" class="form-control" id="packageName" placeholder="Enter Package Name">
    </div>
    <div class="form-group">
        <label for="fee">Fee</label>
        <input type="text" class="form-control" id="fee" placeholder="Enter Fee">
    </div>
    <div class="form-group">
        <label for="info">Info</label>
        <input type="text" class="form-control" id="info" placeholder="Enter Info">
    </div>
    <button type="submit" id="dispatcher" class="btn btn-default" onclick="createNewPackage()">Save</button>
</form>