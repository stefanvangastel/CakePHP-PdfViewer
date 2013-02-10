
<?php
/**
 * PdfViewer using Mozilla/Pdf.js project
 *
 * @author Stefan van Gastel <stefanvangastel AT gmail DOT com>
 *
 **/
?>

<?php
//Check some vars and set defaults
if( ! isset($pdfurl) ){
  $pdfurl = '';
}

//The scale
if( ! isset($scale) ){
  $scale = 1.0;
}

//The class
if( ! isset($class) ){
  $class = '';
}


//The startpage
if( ! isset($startpage) ){
  $startpage = 1;
}
?>

<!-- NOTE: These buttons conain classes to make them nice. These are TwitterBootstrap classes but ofcourse you can change them with your own -->
<div id="pdfviewer-container">
    <button id="prev" class="btn" onclick="goPrevious()"><i class="icon-chevron-left"></i> <?php echo __('Previous page');?></button>
    &nbsp;
    <span>
    	<?php echo __('Showing page');?>: <b><span id="page_num"></span></b> <?php echo __('of');?> <b><span id="page_count"></span></b>
    </span>
    &nbsp;
    <button id="next" class="btn" onclick="goNext()"><?php echo __('Next page');?> <i class="icon-chevron-right"></i></button>

    <!-- Some niceness -->
    <span>
      <!-- Using TwitterBootstrap icons and classes (also in the function changeSize()-->
      <button id="size" class="btn" onclick="changeSize()"><i class="icon-fullscreen"></i></button>
    </span>
</div>

<hr />

<div id="pdfviewer-viewport">
	<canvas id="the-canvas" style="border:1px solid black" class="<?php echo $class; ?>"></canvas>
</div>

<?php
$this->start('script');
?>

 <!-- Uncomment bellow to use latest PDF.js build from Github (slow) -->
 <!-- <script type="text/javascript" src="https://raw.github.com/mozilla/pdf.js/gh-pages/build/pdf.js"></script>-->
<?php echo $this->Html->script('/pdf_viewer/js/pdf-min.js'); ?>

 <!-- Uncomment bellow to use compat.js for non-FF compat from Github (slow)-->
 <!-- <script type="text/javascript" src="https://raw.github.com/mozilla/pdf.js/gh-pages/web/compatibility.js"></script> -->
 <?php echo $this->Html->script('/pdf_viewer/js/compatibility-min.js'); ?>

<script type="text/javascript">
  if ('' == '<?php echo $pdfurl; ?>'){
    document.getElementById('pdfviewer-container').textContent = '<?php echo __('ERROR: Invalid PDF URL provided'); ?>';
    document.getElementById('pdfviewer-viewport').textContent = '';
  }else{

    var url = '<?php echo $pdfurl; ?>';

    PDFJS.disableWorker = true;

    var pdfDoc = null,
        pageNum = <?php echo $startpage; ?>,
        scale = <?php echo $scale; ?>,
        canvas = document.getElementById('the-canvas'),
        ctx = canvas.getContext('2d');

    function renderPage(num) {
        pdfDoc.getPage(num).then(function(page) {
        
        var viewport = page.getViewport(scale);
       
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        page.render(renderContext);
      });

      document.getElementById('page_num').textContent = pageNum;
      document.getElementById('page_count').textContent = pdfDoc.numPages;
    }

    function goPrevious() {
      if (pageNum <= 1)
        return;
      pageNum--;
      renderPage(pageNum);
    }

    function goNext() {
      if (pageNum >= pdfDoc.numPages)
        return;
      pageNum++;
      renderPage(pageNum);
    }

    PDFJS.getDocument(url).then(function getPdfHelloWorld(_pdfDoc) {
      pdfDoc = _pdfDoc;
      renderPage(pageNum);
    });

    //Custom function, I use a span6 (half fluid page) class for my viewer, so I want this function to check the class
    // and then change the class to 12 or back to 6
    function changeSize(){
      //Get the current canvas class and remember it.
      if ( document.getElementById("the-canvas").className.match(/(?:^|\s)span6(?!\S)/) ){
        document.getElementById("the-canvas").className = "span12";
        //Or do some other magic here that would full-screen or max out the canvas
      }else{
        document.getElementById("the-canvas").className = "span6";
        //Or do some other magic here that would reset the size. Maybe use a global var to remember the original state?
      }
    }
  }
</script> 

<?php
$this->end();
?>