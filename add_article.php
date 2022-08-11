<?php
    require_once('conn.php');
    session_start();

    // 讀取 classify
    $sql_cmd = "SELECT classify_name, id FROM classifies";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->execute();
    $classify_result = $stmt->get_result();
    $classify_list = array();
    while($row = $classify_result->fetch_assoc()) {
        array_push($classify_list, array('id'=>$row['id'], 'classify_name'=>$row['classify_name']));
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- <meta charset="UTF-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <style>
            #container {
                width: 100%;
                margin: 20px auto;
            }
            .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 350px;
            }
            .ck-content .image {
                /* block images */
                max-width: 80%;
                margin: 20px auto;
            }
        </style>
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
    <header>
      <div class="header_title"> 
        <h1>Steven's blog </h1>
        <h3>about cs technology, life...</h3>
      </div>
    </header>
    <section>
      <div class="container">
        <div class="row">
          <div class="add_articles col-md-8 pb-3">
            <h2>新增文章</h2>
            <form action="handle_add_article.php" method="post" autocomplete="off" id="article_post">
              <label for="subject"class="form-label">主題</label>
              <input type="text" name="subject" id="subject" class="form-control" required>
              <label for="article_classify"class="form-label">文章分類</label>
              <input list="article_classify_options" name="article_classify" id="article_classify" class="form-control" placeholder="請輸入查詢或新增..." required>
              <datalist id="article_classify_options">
                <?php foreach($classify_list as $classify) { ?>
                  <option value="<?php echo $classify['classify_name'] ?>">
                <?php } ?>
              </datalist>
              <label for="editor"class="form-label">文章內容</label>
              <textarea name="article_content" id="editor" class="form-control mb-2" cols="30" rows="10" placeholder="請輸入文章內容..."></textarea>
              <div class="add_btn d-flex justify-content-end align-items-center">
                <button type="submit" class="add btn">新增文章</button>
              </div>
            </form>
          </div>
          <div class="classify col-md-3 offset-1">  
            <div class="classify container"> 
              <h3>文章分類</h3>
              <ul> 
                <?php
                  foreach($classify_list as $classify) {
                ?>
                  <li> <a href="classify.php?id=<?php echo $classify['id'] ?>">
                    <?php echo $classify['classify_name'] ?>
                  </a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
  <!-- BootStrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- CKEditor -->
  <script src="./build/ckeditor.js"></script>
  <script>
    let CKEditor = ClassicEditor.create(document.querySelector("#editor"), {
			codeBlock: {
				languages: [
					{ language: "css", label: "CSS" },
					{ language: "html", label: "HTML" },
					{ language: "javascript", label: "JavaScript" },
					{ language: "php", label: "PHP" },
					{ language: "xml", label: "XML" },
				],
			},
		});

  </script>
</html>