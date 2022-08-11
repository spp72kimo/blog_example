<?php
    require_once('errMsg.php');

    session_start();
    if(!empty($_SESSION['id']))
        header("Location: index.php");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
     <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css" />
    <title>Steven's blog</title>
  </head>
  <body>
    <nav>
      <div class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid"><a class="navbar-brand" href="index.php">Steven's Blog</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
              <li class="nav-item">
                <a class="nav-link" href="articles.php">
                    <i class="fa-solid fa-newspaper"></i>
                    所有文章
                </a>
            </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-list-ul"></i>
                    文章分類
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <?php 
                    foreach($classify_list as $classify) { 
                  ?>
                    <li> <a class="dropdown-item" href="classify.php?id=<?php echo $classify['id'] ?>">
                        <?php echo $classify['classify_name'] ?>
                    </a></li>
                  <?php } ?>
                </ul>
              </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-md-0">
              <?php if(empty($_SESSION['id'])) { ?>
                <li class="nav-item"><a class="nav-link" href="login.php">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    登入</a></li>
              <?php } else { ?>
                <li class="nav-item"><a class="nav-link" href="add_article.php">
                    <i class="fa-solid fa-plus"></i>
                    新增文章</a></li>
                <li class="nav-item"><a class="nav-link" href="manage.php">
                    <i class="fa-solid fa-sliders"></i>
                    管理文章</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    登出</a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="bottom_bar"> </div>
    </nav>
    <section class="login">
      <div class="login_container container">
        <div
          class="login_logo d-flex justify-content-center align-items-center"
        >
          <h1>Log in</h1>
        </div>
        <div class="login_form">
          <form
            action="handle_login.php"
            method="post"
            class="needs-validation"
            novalidate
          >
            <div>
              <label for="email" class="form-label">E-mail: </label>
              <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                required
              />
              <div class="invalid-feedback mb-2" for="email">
                請輸入 E-mail。
              </div>
            </div>

            <label for="password" class="form-label">密碼：</label>
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              required
            />
            <div class="invalid-feedback mb-2" for="password">
              請輸入密碼。
            </div>
            <div class="login_button d-flex align-items-center justify-content-end">
              <?php if(!empty($_GET['errCode'])) { ?>
                <span class="errMsg"><?php echo $Msg ?></span>
              <?php } ?>
              <button type="submit" class="btn">
                登入
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>
  <script>
    (function () {
      "use strict";

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll(".needs-validation");

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }

            form.classList.add("was-validated");
          },
          false
        );
      });
    })();
  </script>
</html>
