<?php
$base_url = str_replace('/viewer.php', '', 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']);
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Example Scene</title>
    <script src="https://cdn.jsdelivr.net/gh/aframevr/aframe@master/dist/aframe-master.min.js"></script>
</head>
<body>
<a-scene debug="true" background="color:gray;">
    <a-entity light="type:directional; castShadow:true;" position="1 1 5"></a-entity>

    <a-entity
            messagetext front
            text="font:<?php echo $base_url; ?>/assets/PermanentMarker-Regular-msdf.json; value: Klappentext;negate:false; align:center; shader:msdf; color:#fff; width:0.3;opacity:0.9 ; side:double; wrapPixels:450 ; baseline:bottom"
            position="0 1.50 -0.245" scale="1 1 1" rotation="0 0 0"
            animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
            material="side:double"

    ></a-entity>

    <a-entity
            messagetext back
            text="font:<?php echo $base_url; ?>/assets/PermanentMarker-Regular-msdf.json; value: Klappentext;negate:false; align:center; shader:msdf; color:#000; width:0.3;opacity:0.15 ; side:double; wrapPixels:450 ; baseline:bottom"
            position="0.01 1.50 -0.25" scale="1 1 1" rotation="0 0 0"
            animation="property: rotation; to: -10 10 0; dur: 2000; easing: easeInOutQuad; loop: true; dir: alternate"
            material="side:double"

    >
        <a-entity
                authortext front
                text="font:<?php echo $base_url; ?>/assets/PermanentMarker-Regular-msdf.json; value: author;negate:false; align:right; shader:msdf; color:#fff; opacity:0.9 ; side:double; wrapPixels:400"
                position="0 -0.02 0" scale="0.2 0.2 0.2" rotation="0 0 0"
                material="side:double"

        ></a-entity>
        <a-entity
                authortext back
                text="font:<?php echo $base_url; ?>/assets/PermanentMarker-Regular-msdf.json; value: author;negate:false; align:right; shader:msdf; color:#000;opacity:0.15 ; side:double; wrapPixels:400"
                position="0.01 -0.02 -0.005" scale="0.2 0.2 0.2" rotation="0 0 0"
                material="side:double"

        ></a-entity>
    </a-entity>
        <a-image src="<?php echo $base_url; ?>/assets/background.jpg" position="-0.2 2 -3.25" scale="5 3 4" width="2" height="2"  rotation="0 0 0">
    </a-image>

</a-scene>

</body>
</html>
