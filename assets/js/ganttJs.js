//global chart and tree data declaration.
var chart, dataTree;
var getDetail = idproject + "_" + iddiv + "_" + idpt;
/*
 This flag is used to separate total item remove from setting new item parent.
 When remove item from tree - tree dispatches treeItemRemove-event.
 When set new parent to item - tree dispatches treeItemRemove first (removed from old parent) and then treeItemMove-event
 with new parent defined in incoming event object. In this case there is no need to remove anything from database.
 If this flag is set to true, it means that "Remove" button was pressed and item must be removed from database.
 */
var removeFlag = false;

//Selected task ID. Used for sample interactivity.
var selectedTaskId;

//Anychart document ready handler.
anychart.onDocumentReady(function() {
  //this synchronizes DB date to displayed one.
  anychart.format.outputTimezone((new Date()).getTimezoneOffset());
  //loading chart data from database in JSON-format.
  anychart.data.loadJsonFile( base_url + "project/get/" + getDetail, function(data) {
    if (data.fail) {
      console.log(data);
    } else {
      initChart(data);
    }
  });
});

//initialize the chart with data.
function initChart(data) {
  //create Gantt Project Chart.
  chart = anychart.ganttProject();

  var stage = anychart.graphics.create("chartContainer");
  var dataTree = anychart.data.tree(data, 'as-tree');
  var chart = anychart.ganttProject();
  chart.editing(true);
  chart.data(dataTree);
  chart.container(stage).draw();
  // chart.zoomTo(951350400000, 954201600000);

  var buttons = chart.dataGrid().buttons();

  // configure data grid buttons
  buttons.fontWeight(600);
  buttons.fontSize(16);
  buttons.fontFamily("Courier");
  buttons.background().fill(null);
  buttons.background().stroke(null);
  buttons.width(30);
  buttons.cursor("default");

  // configure data grid buttons in the normal state
  buttons.normal().content("[+]");
  buttons.normal().fontColor("#ef6c00");

  // configure data grid buttons in the hover state
  buttons.hovered().content("[+]");
  buttons.hovered().fontColor(anychart.color.lighten("#ef6c00"));

  // configure data grid buttons in the selected state
  buttons.selected().content("[-]");
  buttons.selected().fontColor("#64b5f6");

  //chart row selection listener.
  chart.listen('rowSelect', function(e) {
    if (e.item) { //select: if item presents in event, saving its ID.
      selectedTaskId = e.item.get('id');
    } else { //unselect: if item is absent, it is unselection.
      selectedTaskId = void 0;
      clearEditForm();
    }
    updateEditForm();
  });


  // Data change events.

  //Tree item create listener.
  dataTree.listen('treeItemCreate', function(e) {
    //get created item from event.
    var item = e.item;

    //e.target is parent tree data item. If is null, created item is root item.
    var newParentId = e.target ? e.target.get('id') : 'NULL';

    //JSON data for server.
    var data = {
      action: 'create',
      name: item.get('name'),
      actualStart: item.get('actualStart'),
      actualEnd: item.get('actualEnd'),
      parent: newParentId
    };

    //Send ajax POST request.
    $.ajax({
      type: 'POST',
      url: base_url + "project/action",
      data: data,
      success: function(data) { //success callback.
        if (data.success) { //if success field presents.
          dataTree.dispatchEvents(false); //Stop tree edit-events dispatching.
          item.set('id', data.success); //data.success here contains generated by MySQL id (primary key). Set it to item.
          dataTree.dispatchEvents(true); //Resume tree edit-events dispatching.
        }
        console.log(data);
      },
      dataType: 'json'
    });
  });

  //tree item move listener. Item can be moved by dragging data grid list items.
  dataTree.listen('treeItemMove', function(e) {
    //get moved item.
    var item = e.item;

    //get its id.
    var id = item.get('id');

    //get parent data item. Can be null if item is moved to root.
    var targetItem = e.target;
    var parentId = targetItem ? targetItem.get('id') : 'NULL';

    //JSON data to be sent.
    var data = {type: 'updateTask', id: id, field: 'parent', value: parentId};

    $.ajax({
      type: 'POST',
      url: base_url + "project/action",
      data: data,
      success: function(data) {
        console.log(data);
        alert(data);
        if(data === "Failed To Update Task"){
          window.location.reload();
        }
      },
      dataType: 'json'
    });
  });

  //Tree item update listened.
  dataTree.listen('treeItemUpdate', function(e) {
    //Item that has been updated.
    var item = e.item;

    //Its id.
    var id = item.get('id');

    //Data for server request contains modified field name and new value to set.
    var value = (e.field == 'actualStart' || e.field == 'actualEnd') ? msToMySqlTimestamp(e.value) : e.value;
    var data = {type: 'updateTask', id: id, field: e.field, value: value};

    $.ajax({
      type: 'POST',
      url: base_url + "project/action",
      data: data,
      success: function(data) {
        console.log(data);
        alert(data);
        if(data === "Failed To Update Task"){
          window.location.reload();
        }
      },
      dataType: 'json'
    });
  });

  $('#editButtonAdd').click(function() {
    var asValue = $('#actualStart').data("DateTimePicker").date()._d;
    var aeValue = $('#actualEnd').data("DateTimePicker").date()._d;
    var nameValue = $('#taskName').val();
    if (asValue && aeValue && nameValue) {
      asValue.setSeconds(0);
      aeValue.setSeconds(0);
      var asUtc = asValue.getTime();
      var aeUtc = aeValue.getTime();

      if (isDef(selectedTaskId)) {
        var item = dataTree.search('id', selectedTaskId);
        if (item) {
          //Here's a difference. New item is created not as tree root, but as child of another tree data item.
          var newItem = {
            id: -1,
            name: nameValue,
            actualStart: msToMySqlTimestamp(asUtc),
            actualEnd: msToMySqlTimestamp(aeUtc),
            progressValue: '0%'
          };
          item.addChild(newItem);
          chart.fitAll();
        } else {
          console.log('Not found id: ', selectedTaskId); //Debug info.
        }
      } else {
        console.log('No parent found'); //Debug. Theoretically, it is impossible.
      }
      clearEditForm();
      updateEditForm();
    } else {
      alert('Invalid data, please recheck.')
    }
  });

  updateEditForm();
}


//region -- UI.
function updateEditForm() {
  if (isDef(selectedTaskId)) {
    var type = "detailTask";
    $.ajax({
        url: base_url + "project/modal",
        type: 'get',
        data: {selectedTaskId : selectedTaskId, type : type},
        beforeSend:function(){

        },
        success: function(data){
            $('.isiDetailTask').html(data);   
        }
    });
    // var item = dataTree.search('id', selectedTaskId);
    // $('#editTitle').html('Selected item ID: ' + selectedTaskId);
    // $('#removeTask').attr('disabled', false);
    // $('#editButtonAdd').attr('disabled', false);
    // $('#editButtonSave').html('Save selected task');

    // var asValue = mySqlTimestampToMs(item.get('actualStart'));
    // var aeValue = mySqlTimestampToMs(item.get('actualEnd'));

    // $('#actualStart').data("DateTimePicker").date(new Date(asValue));
    // $('#actualEnd').data("DateTimePicker").date(new Date(aeValue));
    // $('#taskName').val(item.get('name'));
  }
}


//endregion
//region -- Utils.
/**
 * Whether the value is defined.
 * @param {*} val - Value.
 * @return {boolean} - Value is not undefined.
 */
function isDef(val) {
  return val !== void 0;
}


/**
 * Turns milliseconds value to MySQL timestamp looking like '2017-05-02 10:00:00'.
 * @param {number} milliseconds - Ms value.
 * @return {string} - Formatted date.
 */
function msToMySqlTimestamp(milliseconds) {
  var timezoneDate = new Date();
  milliseconds -= timezoneDate.getTimezoneOffset() * 60000;
  return new Date(milliseconds).toISOString().slice(0, 19).replace('T', ' ');
}


/**
 * Turns MySQL timestamp like '2017-05-02 10:00:00' to milliseconds.
 * @param {string} mySqlTimestamp - Value.
 * @return {number} - Milliseconds.
 */
function mySqlTimestampToMs(mySqlTimestamp) {
  return (new Date(mySqlTimestamp)).getTime();
}

//endregion