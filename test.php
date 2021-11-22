<?php
$strcon = mysqli_connect("localhost","root","","phpakhir");
$query = mysqli_query("SELECT * FROM jabatan");
$result = mysqli_query($strcon, $query);
while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
    $jabatan[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'parent' => $row['parent']
      );
}
echo json_encode($orders);



?>
<!DOCTYPE html>
<html>
<head>
    <title>jQuery orgChart Plugin Demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="jquery.orgchart.css" media="all" rel="stylesheet" type="text/css" />
<style type="text/css">
#orgChart{
    width: auto;
    height: auto;
}

#orgChartContainer{
    width: 1000px;
    height: 500px;
    overflow: auto;
    background: #eeeeee;
}

    </style>
</head>
<body><div id="jquery-script-menu">
<div class="jquery-script-center">
<ul>
<li><a href="http://www.jqueryscript.net/chart-graph/Create-An-Editable-Organization-Chart-with-jQuery-orgChart-Plugin.html">Download This Plugin</a></li>
<li><a href="http://www.jqueryscript.net/">Back To jQueryScript.Net</a></li>
</ul>
<div class="jquery-script-ads"><script type="text/javascript"><!--
google_ad_client = "ca-pub-2783044520727903";
/* jQuery_demo */
google_ad_slot = "2780937993";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
<div class="jquery-script-clear"></div>
</div>
</div>
<h1 style="margin-top:150px;">jQuery orgChart Plugin Demo</h1>
    <div id="orgChartContainer">
      <div id="orgChart"></div>
    </div>
    <div id="consoleOutput">
    </div>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jquery.orgchart.js"></script>
    <script type="text/javascript">
    var testData = "<?php json_decode($queryjson); ?>";
    console.log(testData);
    $(function(){
        org_chart = $('#orgChart').orgChart({
            data: testData,
            showControls: true,
            allowEdit: true,
            onAddNode: function(node){ 
                log('Created new node on node '+node.data.id);
                org_chart.newNode(node.data.id); 
            },
            onDeleteNode: function(node){
                log('Deleted node '+node.data.id);
                org_chart.deleteNode(node.data.id); 
            },
            onClickNode: function(node){
                log('Clicked node '+node.data.id);
            }

        });
    });

    // just for example purpose
    function log(text){
        $('#consoleOutput').append('<p>'+text+'</p>')
    }
    </script><script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>