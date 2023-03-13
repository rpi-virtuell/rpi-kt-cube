<?php
$base_url = str_replace('/viewer.php', '', 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Example Scene</title>
    <script src="https://cdn.jsdelivr.net/gh/aframevr/aframe@master/dist/aframe-master.min.js"></script>
</head>
<body>
<a-scene debug="true" background="color:grey;">
    <a-entity light="type:directional; castShadow:true;" position="1 1 5"></a-entity>

    <a-entity
            fronttext
            text="font:<?php echo $base_url;?>/assets/PermanentMarker-Regular-msdf.json; value: Klappentext;negate:false; align:center; shader:msdf; color:#fff; width:0.3;opacity:0.5 ; side:double; wrapPixels:400"
            position="0 1.6 -0.245" scale="1 1 1" rotation="0 0 0"
            animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
            material="side:double"

    ></a-entity>

    <a-entity
            text="font:<?php echo $base_url;?>/assets/PermanentMarker-Regular-msdf.json; value: Klappentext;negate:false; align:center; shader:msdf; color:#000; width:0.3;opacity:0.15 ; side:double; wrapPixels:400"
            position="0.01 1.6 -0.25" scale="1 1 1" rotation="0 0 0"
            animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
            material="side:double"

    ></a-entity>
</a-scene>

</body>
</html>
