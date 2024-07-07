<!-- NOTE
SINGLE PAGE FORM ALONG WITH VALIDATION
NO PHP LEAKS BACK TO THE INDEX 
 -->
<?php
  require_once("Includes/config.php");
  require_once("Includes/session.php");
  /*if(!(isset($_POST['email']&&isset($_POST['pass'])))) {
    location('index.php');
  }*/
   // if ($count === 0) {
  // echo "There were some problem";
// }
  ?>
<style>
  #lgn_btn {
    border: none;
    background-color: lightgreen;
    font-weight: 600;
    color: black;
    border-radius: 3rem;
  }
  #lgn_btn:hover {
    box-shadow: 0 0 8px lightgreen;
    color: white;
  }
</style>

<form action="index.php" class="form-horizontal" role="form" method="post">
  <center>
    <div class="form-group">
      <div class="col-md-12">
        <input type="text" placeholder="Email" name="email" id="email" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-12">
        <input type="password" placeholder="Password" name="pass" id="pass" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-12">
        <button type="login_submit" class="form-control" id="lgn_btn" onclick=" validateForm();">log in</button>
      </div>
    </div>
    </center>
</form>

