<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>
  <div>
    <button name="change_pwd" class="confirm btn btn-lg width-ge-200 fs-20" onclick=location.href="/account/password" type="submit">Change password</button>
  </div>

  <br>
  <div>
    <button name="delete_account" class="cancel btn btn-lg width-ge-200 fs-20" onclick=location.href="/account/delete" type="submit">Delete account</button>
  </div>

</main>

<?php include $this->resolve("partials/_footer.php"); ?>