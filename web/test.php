<?php
    $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
    $allowedTags.='<li><ol><ul><span><div><br><ins><del>';
    // Should use some proper HTML filtering here.
    if($_POST['elm1']!='') {
        $sHeader = '<h1>Ah, content is king.</h1>';
        $sContent = strip_tags(stripslashes($_POST['elm1']),$allowedTags);
    } else {
        $sHeader = '<h1>Nothing submitted yet</h1>';
        $sContent = '<p>Start typing...</p>';
        $sContent.= '<p><img width="107" height="108" border="0" src="/mediawiki/images/badge.png"';
        $sContent.= 'alt="TinyMCE button"/>This rover has crossed over</p>';
    }
?>
<html>
<head>
    <title>My test editor - with tinyMCE and PHP</title>
    <script language="javascript" type="text/javascript" src="../web/lib/tinymce/js/tinymce/tinymce.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="../web/js/tinymce.init.js"></script>
    <script type="text/javascript">
        initTinyMCE('textarea');
    </script>
    <!--<script language="javascript" type="text/javascript">
        tinyMCE.init({
            selector: 'textarea',
            height: 500,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code',
                'latex',
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            theme_advanced_buttons2 : "latex",
        });
    </script>-->
</head>
<body>
<?php echo $sHeader;?>
<h2>Sample using TinyMCE and PHP</h2>
<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
    <textarea rows="15" cols="80"><?php echo $sContent;?></textarea>
    <br />
    <input type="submit" name="save" value="Submit" />
    <input type="reset" name="reset" value="Reset" />
</form>
</body>
</html>