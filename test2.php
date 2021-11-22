<?php
include('include/header.php');
include('include/scripts.php');
$strcon = mysqli_connect("localhost","root","","phpakhir");
$result = mysqli_query($strcon, "SELECT jabatan.*, master_karyawan.Nama FROM jabatan LEFT JOIN 
master_karyawan on jabatan.id_NIK = master_karyawan.NIK WHERE jabatan.id_NIK != 0 OR jabatan.id_NIK = 0");
$rows = [];
while ($row = mysqli_fetch_assoc($result) ) {
    $rows[] = $row;
}
$items = array();
foreach($rows as $item) {
  $items[] = $item['key'];
}
//print_r($items).'<br>';
$jabatans = json_encode($rows); 
$jabatan = str_replace('[', '', $jabatans);
$jabatan = str_replace(']', '', $jabatan);
//print_r($jabatan);  
global $id;
$id = 0;
if (isset($_POST["submit"])) {

    
         $data = ($_POST["testpost"]);
         $array = json_decode($data, true);
         //$item1 = array();
         foreach($array['nodeDataArray'] as $itemd) {
          $item1[] = $itemd['key'];
         }

         print_r($array['nodeDataArray']).'<br>';
         //print_r($rows);
        //  print_r($array['nodeDataArray']);
         $new = array_diff($item1,$items);
         print_r($new);
         $delete = array_diff($items,$item1);
        //  print_r($delete);
        //  print_r($new);
         if(count($new) > 0){ 
          foreach($array['nodeDataArray'] as $item)
          {
              foreach($new as $newdata)
              {
                 if($item['key'] == $newdata)
                 {                
                    //VALIDASI AGAR NAMANYA TIDAK SAMA
                     global $strcon;
                     $key  = htmlspecialchars($item['key']);
                     $name = htmlspecialchars($item['name']);
                     $Nama = htmlspecialchars($item['nama']);
                     echo $Nama;
                     if($Nama != null)
                     {
                        $_query = "SELECT * FROM master_karyawan WHERE Nama LIKE '%$Nama%'";
                        $data_karyawan = mysqli_query($strcon, $_query);
                        $fetch_karyawan  = mysqli_fetch_array($data_karyawan);
                        $id_NIK = $fetch_karyawan['NIK'];
                        if($id_NIK != null)
                        {
                        $query_cekNIK = "SELECT * FROM jabatan WHERE id_NIK = '$id_NIK' ";
                        $data_nik = mysqli_query($strcon, $query_cekNIK);
                        $fetch_nik = mysqli_fetch_array($data_nik);
                        if($fetch_nik == "")
                        {
                        $id_NIK = $fetch_karyawan['NIK'];
                        }
                        else
                        {
                        $id_NIK = 0;
                        }
                        }
                     }
                     $id_NIK = 0;
                     if($item["parent"] == null )
                     {
                       $parent = 0;
                     }
                     else
                     {
                       $parent = htmlspecialchars($item["parent"]);
                     }
                     $parent_name = "";
                     $query_add = "INSERT INTO jabatan VALUES('','$name','$parent','$parent_name','$id_NIK')";
                     echo $query_add;
                     mysqli_query($strcon, $query_add);
                     if(mysqli_affected_rows($strcon) > 0 )
                      {
                        $Action = 'INSERT'; 
                        $date = date("d.m.Y, H:i:s");
                        $waktu = date("Y-m-d H:i:s", strtotime($date));
                        $query_history_jabatan_add = "INSERT INTO history_jabatan VALUES('',$key,'$name','$parent','$id_NIK','$Action'
                        ,'$waktu','$parent_name')";
                        mysqli_query($strcon, $query_history_jabatan_add);
                      }
                 }
              }              
           }
         }
        //  return header('Location: http://localhost:8080/teskhirPHP/test2.php');
         if(count($delete) >= 0)
         {
            foreach($delete as $deletedata)
            {          
              print_r($delete);
              global $strcon;
              $id = $deletedata;
              $query_jabatan = "SELECT * FROM jabatan WHERE `key` = '$id'";
              $data_jabatan = mysqli_query($strcon, $query_jabatan);
              $fetchdata = mysqli_fetch_array($data_jabatan);
              $key = $fetchdata['key'];
              $name = $fetchdata['name'];
              $parent = $fetchdata['parent'];
              $id_NIK = $fetchdata['id_NIK'];
              $parent_name = $fetchdata['parentname'];
              $jabatan = mysqli_query($strcon,"DELETE FROM jabatan WHERE `key` = '$id'");
              if(mysqli_affected_rows($strcon) > 0 )
              {
                 $Action = 'DELETE'; 
                 $date = date("d.m.Y, H:i:s");
                 $waktu = date("Y-m-d H:i:s", strtotime($date));
                 $query_history_add = "INSERT INTO history_jabatan VALUES('','$key','$name','$parent','$id_NIK' ,'$Action'
                 ,'$waktu','$parent_name')";
                 mysqli_query($strcon, $query_history_add);
              }  
            } 
           
          }
          
          ?>
<script type="text/javascript">
 $(document).ready(function() {
        $('#dataTable').dataTable( {

        order:[[0,'desc']]
        } );
        });
  window.location.href = 'http://localhost:8080/teskhirPHP/test2.php';
</script>
<?php
}
?>
<link rel="stylesheet" href="assets/css/style.css" />
<script src="release/go.js"></script>
<div class="p-4 w-full">

  <link rel="stylesheet" href="extensions/DataInspector.css" />
  <script src="samples/assets/require.js"></script>
  <script src="extensions/DataInspector.js"></script>
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <!-- <script src="https://unpkg.com/gojs"></script> -->
  <script id="code">
    //console.log("HERE");
    function init() {
      var $ = go.GraphObject.make; // for conciseness in defining templates
      //console.log("HERE");
      myDiagram =
        $(go.Diagram, "myDiagramDiv", // must be the ID or reference to div
          {

            maxSelectionCount: 1, // users can select only one part at a time
            validCycle: go.Diagram.CycleDestinationTree, // make sure users can only create trees
            "clickCreatingTool.archetypeNodeData": { // allow double-click in background to create a new node
              name: "",
              nama: "",
              parent: ""

            },
            "clickCreatingTool.insertPart": function (loc) { // scroll to the new node
              var node = go.ClickCreatingTool.prototype.insertPart.call(this, loc);
              if (node !== null) {
                this.diagram.select(node);
                console.log(node);
                this.diagram.commandHandler.scrollToPart(node);
                this.diagram.commandHandler.editTextBlock(node.findObject("NAMETB"));
              }
              return node;
            },
            layout: $(go.TreeLayout, {
              treeStyle: go.TreeLayout.StyleLastParents,
              arrangement: go.TreeLayout.ArrangementHorizontal,
              // properties for most of the tree:
              angle: 90,
              layerSpacing: 35,
              // properties for the "last parents":
              alternateAngle: 90,
              alternateLayerSpacing: 35,
              alternateAlignment: go.TreeLayout.AlignmentBus,
              alternateNodeSpacing: 20
            }),
            "undoManager.isEnabled": true // enable undo & redo
          });

      // when the document is modified, add a "*" to the title and enable the "Save" button
      myDiagram.addDiagramListener("Modified", function (e) {
        var button = document.getElementById("SaveButton");
        if (button) button.disabled = !myDiagram.isModified;
        var idx = document.title.indexOf("*");
        console.log(idx);
        if (myDiagram.isModified) {
          if (idx < 0) document.title += "*";
        } else {
          if (idx >= 0) document.title = document.title.substr(0, idx);
          console.log(idx);
        }
      });

      // manage boss info manually when a node or link is deleted from the diagram
      myDiagram.addDiagramListener("SelectionDeleting", function (e) {
        var part = e.subject.first(); // e.subject is the myDiagram.selection collection,
        // so we'll get the first since we know we only have one selection
        myDiagram.startTransaction("clear boss");
        if (part instanceof go.Node) {
          var it = part.findTreeChildrenNodes(); // find all child nodes
          while (it.next()) { // now iterate through them and clear out the boss information
            var child = it.value;
            console.log(child)
            var bossText = child.findObject(
              "boss"); // since the boss TextBlock is named, we can access it by name
            if (bossText === null) return;
            bossText.text = "";
          }
        } else if (part instanceof go.Link) {
          var child = part.toNode;
          var deadkey = child.data['key'];
          var bossText = child.findObject(
            "boss");
          // since the boss TextBlock is named, we can access it by name
          if (bossText === null) return;
          bossText.text = "";
          jQuery.ajax({
            type: "POST",
            url: 'deleterelation.php',
            dataType: 'json',
            data: {
              deadkey
            },
            success: function () {

            }
          });
          console.log('BOSS TEXT IS NULLL');

        }
        myDiagram.commitTransaction("clear boss");
      });

      var levelColors = ["#AC193D", "#2672EC", "#8C0095", "#5133AB",
        "#008299", "#D24726", "#008A00", "#094AB2"
      ];

      // override TreeLayout.commitNodes to also modify the background brush based on the tree depth level
      myDiagram.layout.commitNodes = function () {
        go.TreeLayout.prototype.commitNodes.call(myDiagram.layout); // do the standard behavior
        // then go through all of the vertexes and set their corresponding node's Shape.fill
        // to a brush dependent on the TreeVertex.level value
        myDiagram.layout.network.vertexes.each(function (v) {
          if (v.node) {
            var level = v.level % (levelColors.length);
            var color = levelColors[level];
            var shape = v.node.findObject("SHAPE");
            if (shape) shape.stroke = $(go.Brush, "Linear", {
              0: color,
              1: go.Brush.lightenBy(color, 0.05),
              start: go.Spot.Left,
              end: go.Spot.Right
            });
          }
        });
      };

      // when a node is double-clicked, add a child to it
      function nodeDoubleClick(e, obj) {
        var clicked = obj.part;
        console.log(clicked);
        if (clicked !== null) {
          var thisemp = clicked.data;
          myDiagram.startTransaction("add employee");
          var newemp = {

            name: "Nama Jabatan",
            nama: "",
            parent: thisemp.key
          };
          myDiagram.model.addNodeData(newemp);
          myDiagram.commitTransaction("add employee");
        }
      }

      // this is used to determine feedback during drags
      function mayWorkFor(node1, node2) {
        if (!(node1 instanceof go.Node)) return false; // must be a Node
        if (node1 === node2) return false; // cannot work for yourself
        if (node2.isInTreeOf(node1)) return false; // cannot work for someone who works for you
        //console.log(node1);
        //INI NGAMBIL DATA NODE YANG DI TUJU 
        return true;
      }

      // This function provides a common style for most of the TextBlocks.
      // Some of these values may be overridden in a particular TextBlock.
      function textStyle() {
        return {
          font: "9pt  Segoe UI,sans-serif",
          stroke: "white"
        };
      }



      // define the Node template
      myDiagram.nodeTemplate =
        $(go.Node, "Auto", {
            doubleClick: nodeDoubleClick
          }, { // handle dragging a Node onto a Node to (maybe) change the reporting relationship
            mouseDragEnter: function (e, node, prev) {
              var diagram = node.diagram;
              var kuncian = node.data['key'];
              console.log(kuncian);
              var selnode = diagram.selection.first();
              if (!mayWorkFor(selnode, node)) return;
              var shape = node.findObject("SHAPE");
              if (shape) {
                shape._prevFill = shape.fill; // remember the original brush
                shape.fill = "darkred";
              }
            },
            mouseDragLeave: function (e, node, next) {
              var shape = node.findObject("SHAPE");
              if (shape && shape._prevFill) {
                shape.fill = shape._prevFill; // restore the original brush
              }
            },

            mouseDrop: function (e, node) {
              var diagram = node.diagram;
              var key_node_fixed = node.data['key'];
              //console.log(key_node_fixed);
              var selnode = diagram.selection.first(); // assume just one Node in selection
              // console.log(selnode.data['key']);

              if (mayWorkFor(selnode, node)) {
                // find any existing link into the selected node

                var link = selnode.findTreeParentLink();
                if (link !== null) { // reconnect any existing link

                  link.fromNode = node;
                  var key1 = selnode.data['key'];
                  //console.log(node.data['parent']);
                  var key2 = node.data['key'];

                  //ya ini pookoe udah dapt key 1 dan key 2 
                  jQuery.ajax({
                    type: "POST",
                    url: 'editjabatan.php',
                    dataType: 'json',
                    data: {
                      key1,
                      key2
                    },
                    success: function () {

                    }
                  });
                } else { // else create a new link
                  //console.log("kontol");
                  var test = diagram.toolManager.linkingTool.insertLink(node, node.port, selnode, selnode.port);
                  var datakey = test.data['key'];
                  var name = test.data['name'];
                  var nama = test.data['Nama'];
                  // console.log(nama);
                  var dataparent = test.data['parent'];
                  jQuery.ajax({
                    type: "POST",
                    url: 'editnulljabatan.php',
                    dataType: 'json',
                    data: {
                      datakey,
                      dataparent,
                      name,
                      nama
                    },
                    success: function () {}
                  });
                }
              }
            }
          },
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function (sel) {
            return sel ? "Foreground" : "";
          }).ofObject(),
          // define the node's outer shape
          $(go.Shape, "Rectangle", {
            name: "SHAPE",
            fill: "#333333",
            stroke: 'white',
            strokeWidth: 3.5,
            // set the port properties:
            portId: "",
            fromLinkable: true,
            toLinkable: true,
            cursor: "pointer"
          }),
          $(go.Panel, "Horizontal",

            // define the panel where the text will appear
            $(go.Panel, "Table", {
                minSize: new go.Size(130, NaN),
                maxSize: new go.Size(150, NaN),
                margin: new go.Margin(6, 10, 0, 6),
                defaultAlignment: go.Spot.Left
              },
              $(go.RowColumnDefinition, {
                column: 2,
                width: 4
              }),
              $(go.TextBlock, textStyle(), // the name
                {
                  row: 0,
                  column: 0,
                  columnSpan: 5,
                  font: "12pt Segoe UI,sans-serif",
                  editable: true,
                  isMultiline: false,
                  minSize: new go.Size(10, 16)
                },
                new go.Binding("text", "name").makeTwoWay()),
              $(go.TextBlock, "Nama: ", textStyle(), {
                row: 1,
                column: 0
              }),
              $(go.TextBlock, textStyle(), {
                  row: 1,
                  column: 1,
                  columnSpan: 4,
                  editable: true,
                  isMultiline: false,
                  minSize: new go.Size(10, 14),
                  margin: new go.Margin(0, 0, 0, 3)
                },
                new go.Binding("text", "Nama").makeTwoWay()),
              $(go.TextBlock, textStyle(), {
                  row: 2,
                  column: 0
                },
                new go.Binding("text", "key", function (v) {
                  return "ID: " + v;
                })),
              $(go.TextBlock, textStyle(), {
                  name: "boss",
                  row: 2,
                  column: 3,
                }, // we include a name so we can access this TextBlock when deleting Nodes/Links
                new go.Binding("text", "parent", function (v) {
                  return "Boss: " + v;
                })),
              $(go.TextBlock, textStyle(), // the comments
                {
                  row: 3,
                  column: 0,
                  columnSpan: 5,
                  font: "italic 9pt sans-serif",
                  wrap: go.TextBlock.WrapFit,
                  editable: true, // by default newlines are allowed
                  minSize: new go.Size(10, 14)
                },
                new go.Binding("text", "comments").makeTwoWay())
            ) // end Table Panel
          ) // end Horizontal Panel
        ); // end Node

      // the context menu allows users to make a position vacant,
      // remove a role and reassign the subtree, or remove a department
      myDiagram.linkTemplate =
        $(go.Link, go.Link.Orthogonal, {
            corner: 5,
            relinkableFrom: true,
            relinkableTo: true
          },
          $(go.Shape, {
            strokeWidth: 1.5,
            stroke: "#F5F5F5"
          })); // the link shape

      // read in the JSON-format data from the "mySavedModel" element
      load();


      // support editing the properties of the selected person in HTML
      if (window.Inspector) myInspector = new Inspector("myInspector", myDiagram, {
        properties: {
          "key": {},
        }
      });
      console.log((myInspector)._inspectedProperties);
      // Setup zoom to fit button


    } // end init

    // Show the diagram's model in JSON format
    function save() {
      document.getElementById("mySavedModel").value = myDiagram.model.toJson();
      document.getElementById("testpost").value = myDiagram.model.toJson();
      document.getElementById("savedb").click();
      myDiagram.isModified = false;

    }

    function load() {
      myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
      // make sure new data keys are unique positive integers
      var lastkey = 1;
      myDiagram.model.makeUniqueKeyFunction = function (model, data) {
        var k = data.key || lastkey;
        while (model.findNodeDataForKey(k)) k++;
        data.key = lastkey = k;
        return k;
      };
    }

    function generatePdf(action, diagram, options) {
      if (!(diagram instanceof go.Diagram)) throw new Error("no Diagram provided when calling generatePdf");
      if (!options) options = {};

      var pageSize = options.pageSize || "LETTER";
      pageSize = pageSize.toUpperCase();
      if (pageSize !== "LETTER" && pageSize !== "A4") throw new Error("unknown page size: " + pageSize);
      // LETTER: 612x792 pt == 816x1056 CSS units
      // A4: 595.28x841.89 pt == 793.71x1122.52 CSS units
      var pageWidth = (pageSize === "LETTER" ? 612 : 595.28) * 96 / 72; // convert from pt to CSS units
      var pageHeight = (pageSize === "LETTER" ? 792 : 841.89) * 96 / 72;

      var layout = options.layout || "portrait";
      layout = layout.toLowerCase();
      if (layout !== "portrait" && layout !== "landscape") throw new Error("unknown layout: " + layout);
      if (layout === "landscape") {
        var temp = pageWidth;
        pageWidth = pageHeight;
        pageHeight = temp;
      }

      var margin = options.margin !== undefined ? options.margin : 36; // pt: 0.5 inch margin on each side
      var padding = options.padding !== undefined ? options.padding : diagram.padding; // CSS units

      var imgWidth = options.imgWidth !== undefined ? options.imgWidth : (pageWidth - margin / 72 * 96 *
        2); // CSS units
      var imgHeight = options.imgHeight !== undefined ? options.imgHeight : (pageHeight - margin / 72 * 96 *
        2); // CSS units
      var imgResolutionFactor = options.imgResolutionFactor !== undefined ? options.imgResolutionFactor : 1;

      var pageOptions = {
        size: pageSize,
        margin: margin, // pt
        layout: layout
      };

      require(["blob-stream", "pdfkit"], function (blobStream, PDFDocument) {
        var doc = new PDFDocument(pageOptions);
        var stream = doc.pipe(blobStream());
        var bnds = diagram.documentBounds;

        // add some descriptive text
        //doc.text(diagram.nodes.count + " nodes, " + diagram.links.count + " links  Diagram size: " + bnds.width.toFixed(2) + " x " + bnds.height.toFixed(2));

        var db = diagram.documentBounds.copy().subtractMargin(diagram.padding).addMargin(padding);
        var p = db.position;

        // if any page has no Parts partially or fully in it, skip rendering that page
        var r = new go.Rect(p.x, p.y, db.width, db.height);

        var makeOptions = {};
        if (options.parts !== undefined) makeOptions.parts = options.parts;
        if (options.background !== undefined) makeOptions.background = options.background;
        if (options.showTemporary !== undefined) makeOptions.showTemporary = options.showTemporary;
        if (options.showGrid !== undefined) makeOptions.showGrid = options.showGrid;
        makeOptions.scale = imgResolutionFactor;
        makeOptions.position = new go.Point(p.x, p.y);
        makeOptions.size = new go.Size(db.width * imgResolutionFactor, db.height * imgResolutionFactor);
        makeOptions.maxSize = new go.Size(Infinity, Infinity);

        var imgdata = diagram.makeImageData(makeOptions);
        doc.image(imgdata, {
          scale: 1 / (imgResolutionFactor * 96 / 72 * Math.max(db.width / imgWidth, db.height / imgHeight))
        });

        doc.end();
        stream.on('finish', function () {
          action(stream.toBlob('application/pdf'));
        });
      });
    }


    // Two different uses of generatePdf: one shows the PDF document in the page,
    // the other downloads it as a file and the user specifies where to save it.

    var pdfOptions = // shared by both ways of generating PDF
      {
        // layout: "landscape",  // instead of "portrait"
        // pageSize: "A4"        // instead of "LETTER"
      };

    function showPdf() {
      generatePdf(function (blob) {
        var datauri = window.URL.createObjectURL(blob);
        var frame = document.getElementById("myFrame");
        if (frame) {
          frame.style.display = "block";
          frame.src = datauri; // doesn't work in IE 11, but works everywhere else
          setTimeout(function () {
            window.URL.revokeObjectURL(datauri);
          }, 1);
        }
      }, myDiagram, pdfOptions);
    }

    function downloadPdf() {
      generatePdf(function (blob) {
        var datauri = window.URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.style = "display: none";
        a.href = datauri;
        a.download = "myDiagram.pdf";

        if (window.navigator.msSaveBlob !== undefined) { // IE 11 & Edge
          window.navigator.msSaveBlob(blob, a.download);
          window.URL.revokeObjectURL(datauri);
          return;
        }

        document.body.appendChild(a);
        requestAnimationFrame(function () {
          a.click();
          window.URL.revokeObjectURL(datauri);
          document.body.removeChild(a);
        });
      }, myDiagram, pdfOptions);
    }
    window.addEventListener('DOMContentLoaded', init);
  </script>

  <div id="sample">
    <div id="myDiagramDiv" style="background-color: #34343C; border: solid 1px black; height: 570px;">
    </div>
    <div>
      <div id="myInspector">
      </div>
    </div>
    <div>
      <div>
        <form method="post">
          <input hidden id="testpost" name="testpost"></input>
          <button hidden id="savedb" type="submit" name="submit" method="post">database</button>
        </form>
        <button id="SaveButton" onclick="save()">Save</button>
        <button hidden onclick="load()">Load</button>
        <div id="sample">

          <div><button onclick="showPdf()">Show PDF</button> <button onclick="downloadPdf()">Download PDF</button>
          </div>
          <iframe id="myFrame" style="display:none; width:1000px; height:1000px"></iframe>
        </div>
      </div>
      <textarea hidden id="mySavedModel" style="width:100%; height:270px;">
          { "class": "go.TreeModel",
          "nodeDataArray": [
          <?php print_r($jabatan); ?>
          ]
          }   
          </textarea>
      <br>
      <?php 
           $strcon = mysqli_connect("localhost","root","","phpakhir");
           //DARI TABEL JABATAN
           $result = mysqli_query($strcon, "SELECT jabatan.*, master_karyawan.Nama, master_karyawan.NIK FROM jabatan LEFT JOIN 
           master_karyawan on jabatan.id_NIK = master_karyawan.NIK WHERE jabatan.id_NIK != 0 OR jabatan.id_NIK = 0");
          
           $rows = [];
           while ($row = mysqli_fetch_assoc($result) ) {
             $rows[] = $row;
           }
           ;
           ?>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="tambahjabatan.php" class="btn btn-primary bottom-buffer" id="btn-add-karyawan"
            style="float:right;"><i class="fa fa-plus"></i> Tambah </a>
          <h6 class="m-0 font-weight-bold text-primary">Table Karyawan</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>NIK</th>
                  <th class="d-none d-sm-table-cell">Nama</th>
                  <th class="d-none d-sm-table-cell" style="width: 15%;">Jabatan</th>
                  <th class="text-center" style="width: 15%;">Atasan</th>
                  <th class="text-center" style="width: 15%;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach( $rows as $row ) : ?>
                <tr>

                  <td class="font-w600"><?= $row["NIK"] ?></td>
                  <td class="font-w600"><?= $row["Nama"] ?></td>
                  <td class="font-w600"><?= $row["name"] ?></td>
                  <?php 
                        $dataname = $row['parent'];
                        //echo $dataname;
                        global $strcon;
                        $results = mysqli_query($strcon, "SELECT jabatan.*, master_karyawan.Nama, master_karyawan.NIK FROM jabatan LEFT JOIN 
                        master_karyawan on jabatan.id_NIK = master_karyawan.NIK WHERE jabatan.key = $dataname LIMIT 1 ");
                        $fetch_jabatans = mysqli_fetch_assoc($results);
                        if($fetch_jabatans)
                        {
                           echo '<td class="font-w600">'.$fetch_jabatans["Nama"].' - '.$fetch_jabatans["name"].'</td>';
                        }
                        else
                        {
                          echo '<td class="font-w600"></td>';
                        }
              
                      ?>
                  <td class="text-center">
                    <a href="editjabatan_table.php?id=<?=$row["key"];?>" title="edit"
                      class="btn btn-xs btn-secondary"><i class="fa fa-edit fa-fw fa-xs"></i></a>
                    <a href="hapusjabatan.php?id=<?=$row["key"];?>" title="delete" class="btn btn-xs btn-danger"><i
                        class="fa fa-trash fa-fw fa-xs"></i></a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php 
include('include/footer.php');
?>