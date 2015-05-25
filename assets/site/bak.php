<?php
require($this->__RAD__ . '_head.php');
?>
</head>
<body>
<script>
    var fwidth = '100%';// flash view width
    var fheight = '100%'; // flash view height
    installPlayer("<?= $this->__STATIC__ ?>Scratch.swf", 'scratch');
    function installPlayer(swfName, swfID) {
        var flashvars = {
            project: '<?= $this->__STATIC__ ?>Animan.sb2',
            autostart: 'false'
        };
        var params = {
            allowScriptAccess: 'always',
            allowFullScreen: 'true',
            wmode: 'direct',
            menu: 'false'
        };
        var attributes = {};
        swfobject.embedSWF(swfName, swfID, fwidth, fheight, '10.2.0', false, flashvars, params, attributes);
    }
</script>
<div id="scratch"></div>
</body>
</html>