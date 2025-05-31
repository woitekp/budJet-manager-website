<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_menu.php"); ?>

<main>
  <p class="msg">
    Are you sure you want to delete your account?
    <br>
    All data will be lost and it cannot be undone!
  </p>

  <form action='/account/delete' method="POST">
    <input type="hidden" name="_METHOD" value="DELETE" />

    <?php include $this->resolve("partials/_csrf.php") ?>

    <div>
      <button name="delete_account" class="cancel btn btn-lg width-ge-200 fs-20" onclick=location.href="/account/delete" type="submit">Delete account</button>
    </div>
  </form>
</main>


<?php include $this->resolve("partials/_footer.php"); ?>