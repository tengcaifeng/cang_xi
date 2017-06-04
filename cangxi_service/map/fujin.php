<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.min.css">

    <title>附近搜</title>
    <style type="text/css">
        html {
            height: 100%
        }
        body {
            height: 100%;
            margin: 0px;
            padding: 0px
        }
        #container {
            width: 100%;
            height: 60%;
            margin:0 auto;
        }

    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Lim3MZ2qFNRKoNhgjXMQdEQLXOGwdH2G">
        //v2.0版本的引用方式：src="http://api.map.baidu.com/api?v=2.0&ak=您的密钥"
        //v1.4版本及以前版本的引用方式：src="http://api.map.baidu.com/api?v=1.4&key=您的密钥&callback=initialize"
    </script>
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
</head>

<body>
<a href=" http://tcf.natapp1.cc/cangxi_demo/cangxi_service/demo.html" ><button type="button" class="btn btn-primary " style="position: fixed;right: 20px;top:5px; z-index: 10000">返回</button></a>

<div id="container"></div>

<!--关键词查询-->
<div id="r-result3"></div>
<div id="key_way">
    <h3 style="margin-top: 0px;">附近搜</h3>
    拖动<b style="color:#ff030c;">红色</b>标注到搜索地点：<input placeholder="搜索地点" type="text" name="add" id="add" value="" class="form-control"><br/>
     <input placeholder="搜索内容" type="text" name="key" id="key" value="" class="form-control" ><br/>
    <input  type="button" id="result3" value="查询"  class="btn btn-info btn-block">

    <!-- 经度：--><input id="lng" name="lng" type="hidden" maxlength="10" class="form-control" >
    <!--纬度：--><input id="lat" name="lat" type="hidden" maxlength="10" class="form-control" ><br/>
</div>
<!--关键词查询-->

</body>
</html>

<script type="text/javascript">
    var map = new BMap.Map("container");          // 创建地图实例
    var point = new BMap.Point(104.000285, 30.586164);/*经度，纬度*/ // 创建点坐标
    map.centerAndZoom(point, 14);                 // 初始化地图，设置中心点坐标和地图级别

    var marker = new BMap.Marker(point);        // 创建标注,point是坐标，可以再新建point
    map.addOverlay(marker);                     // 将标注添加到地图中

    map.enableScrollWheelZoom();                    //鼠标滚轮
    map.setDefaultCursor("crosshair");              //设置鼠标样式


    /*新添加版权信息*/
    var cr = new BMap.CopyrightControl({anchor: BMAP_ANCHOR_TOP_LEFT});   //设置版权控件位置
    map.addControl(cr); //添加版权控件
    var bs = map.getBounds();   //返回地图可视区域
    cr.addCopyright({id: 1, content: "<p style='font-size:20px;background:#e2e2e2'>苍溪发布</p>", bounds: bs});
    /*新添加版权信息*/
    var Navigation = {enableGeolocation:true} ; //控件是否集成定位功能，默认为false
    map.addControl(new BMap.NavigationControl(Navigation));   //地图平移缩放控件，PC端默认位于地图左上方，它包含控制地图的平移和缩放的功能。移动端提供缩放控件，默认位于地图右下方。
    map.addControl(new BMap.OverviewMapControl());  //缩略地图控件，默认位于地图右下方，是一个可折叠的缩略地图。
    map.addControl(new BMap.ScaleControl());    //比例尺控件，默认位于地图左下方，显示地图的比例关系。
    map.addControl(new BMap.MapTypeControl({offset:new BMap.Size(10,50)}));  //地图类型控件，默认位于地图右上方。
    map.setCurrentCity("成都"); // 仅当设置城市信息时，MapTypeControl的切换功能才能可用
    //map.addControl(new BMap.CopyrightControl());  //版权控件，默认位于地图左下方。
    var Geolocation = {anchor:BMAP_ANCHOR_BOTTOM_RIGHT,offset: new BMap.Size(0, 100)}; //定位功能距离地图的位置
    map.addControl(new BMap.GeolocationControl(Geolocation));  //定位控件，针对移动端开发，默认位于地图左下方。

    /*先点击获取经纬度*/
    map.addEventListener("click",function (e) {
        document.getElementById("lng").value = e.point.lng;/*经度*/
        document.getElementById("lat").value = e.point.lat;/*纬度*/
    })
    /*先点击获取经纬度*/


    /*拖动标注显示信息*/
    marker.enableDragging();        //容许拖动
    var gc = new BMap.Geocoder(); //地址解析实列化
    marker.addEventListener("dragend", function(e){
        document.getElementById("lng").value = e.point.lng;/*经度*/
        document.getElementById("lat").value = e.point.lat;/*纬度*/
        gc.getLocation(e.point, function(rs)
        {
            showLocationInfo(e.point, rs);
        });

    })
    function showLocationInfo(pt, rs)
    {
        var opts = {  width : 100, height: 75, title : "当前位置" } ;
        var addComp = rs.addressComponents;
        var addr = addComp.province + "" + addComp.city + "" + addComp.district + "" + addComp.street + "" + addComp.streetNumber + "";
        /*  addr += "经度: " + pt.lng + ", " + "纬度：" + pt.lat;*/
        var infoWindow = new BMap.InfoWindow(addr, opts);
        //infoWindow.enableAutoPan();
        marker.openInfoWindow(infoWindow);
        document.getElementById("add").value= addr;
    }
    /*拖动标注显示信息*/

    // 复杂的自定义覆盖物
    function ComplexCustomOverlay(point, text, mouseoverText){
        this._point = point;
        this._text = text;
        this._overText = mouseoverText;
    }
    ComplexCustomOverlay.prototype = new BMap.Overlay();
    ComplexCustomOverlay.prototype.initialize = function(map){
        this._map = map;
        var div = this._div = document.createElement("div");
        div.style.position = "absolute";
        div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
        div.style.backgroundColor = "#EE5D5B";
        div.style.border = "1px solid #BC3B3A";
        div.style.color = "white";
        /*div.style.height = "18px";*/
        div.style.padding = "2px";
        div.style.lineHeight = "18px";
        div.style.whiteSpace = "nowrap";
        div.style.MozUserSelect = "none";
        div.style.fontSize = "12px"
        div.style.borderRadius = "4px";
        var span = this._span = document.createElement("span");
        div.appendChild(span);
        span.appendChild(document.createTextNode(this._text));
        var that = this;

        var arrow = this._arrow = document.createElement("div");
        arrow.style.background = "url(http://map.baidu.com/fwmap/upload/r/map/fwmap/static/house/images/label.png) no-repeat";
        arrow.style.position = "absolute";
        arrow.style.width = "11px";
        arrow.style.height = "10px";
        arrow.style.top = "22px";
        arrow.style.left = "10px";
        arrow.style.overflow = "hidden";
        div.appendChild(arrow);

        div.onmouseover = function(){
            this.style.backgroundColor = "#6BADCA";
            this.style.borderColor = "#0000ff";
            this.getElementsByTagName("span")[0].innerHTML = that._overText;
            arrow.style.backgroundPosition = "0px -20px";

            //div.style.padding = "20px";
        }
        div.onmouseout = function(){
            this.style.backgroundColor = "#EE5D5B";
            this.style.borderColor = "#BC3B3A";
            this.getElementsByTagName("span")[0].innerHTML = that._text;
            arrow.style.backgroundPosition = "0px 0px";

            div.style.padding = "2px";
        }


        div.ontouchstart= function(){
            this.style.backgroundColor = "#6BADCA";
            this.style.borderColor = "#0000ff";
            this.getElementsByTagName("span")[0].innerHTML = that._overText;
            arrow.style.backgroundPosition = "0px -20px";

            span.style.marginLeft = "20px";
            div.style.padding = "20px";
            div.style.fontSize = "20px"
        }
        div.ontouchend = function(){
            this.style.backgroundColor = "#EE5D5B";
            this.style.borderColor = "#BC3B3A";
            this.getElementsByTagName("span")[0].innerHTML = that._text;
            arrow.style.backgroundPosition = "0px 0px";
            arrow.style = "none";
            span.style.marginLeft = "0px";
            div.style.padding = "2px";
            div.style.fontSize = "14px"
        }

        map.getPanes().labelPane.appendChild(div);

        return div;
    }
    ComplexCustomOverlay.prototype.draw = function(){
        var map = this._map;
        var pixel = map.pointToOverlayPixel(this._point);
        this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
        this._div.style.top  = pixel.y - 30 + "px";
    }

    var txt = "环球中心", mouseoverTxt = txt + "成都最大购物乐园 " ;
    var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(104.071143,30.561165), txt,mouseoverTxt);
    map.addOverlay(myCompOverlay);

    var txt2 = "机场", mouseoverTxt2 ="成都" +txt2  ;
    var myCompOverlay2 = new ComplexCustomOverlay(new BMap.Point(103.965934,30.58691), txt2,mouseoverTxt2);
    map.addOverlay(myCompOverlay2);
    // 复杂的自定义覆盖物


    /*关键词搜索*/
    var local = new BMap.LocalSearch(map, {
        renderOptions: {map: map, panel: "r-result3"}
    });

    $("#result3").click(function (e) {
        map.clearOverlays();
        var key = $("#key").val();
        var add = $("#add").val();
        //var point = new BMap.Point(e.point.lng,e.point.lat);/*经度，纬度*/ // 创建点坐标
        local.searchNearby(key,add,2000);
    })
    /*关键词搜索*/
</script>