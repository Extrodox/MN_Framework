
  <script src="..//start/js/jquery-latest.js"></script>
  <script type="text/javascript" src="..//start/js/jquery-validate.js"></script>
<style type="text/css">
  * {
       font-family: Verdana;
       font-size: 96%; 
    }
  label {
         width: 10em; float: left; }
label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
p { clear: both; }
.submit { margin-left: 12em; }
em { font-weight: bold; padding-right: 1em; vertical-align: top; }
</style>
  <script>
  $(document).ready(function(){
    $("#[:name]Form").validate();
  });
  </script>
<?php
if(isset($this->view->report)){
  echo "<b>{$this->view->report}</b><br/>";
}
?>  
<?php
if(isset($this->view->errors)){
  foreach ($this->view->errors as $e) {
    echo "<b>$e</b><br/>";
  }
}
?>
 <form class="cmxform" id="[:name]Form" method="get" action="">
 <fieldset>
   <legend>A simple comment form with submit validation and default messages</legend>
   <p>
     <label for="cname">Name</label>
     <em>*</em><input id="cname" name="name" size="25" class="required" minlength="2" />
   </p>
   <p>
     <label for="cemail">E-Mail</label>
     <em>*</em><input id="cemail" name="email" size="25"  class="required email" />
   </p>
   <p>
     <input type="submit" value="Submit"/>
   </p>
 </fieldset>
 </form>
