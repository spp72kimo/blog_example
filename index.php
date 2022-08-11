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

    // 讀取最近 5 篇文章
    $sql_cmd = "SELECT 
        A.id AS id,
        A.subject AS subject,
        A.content AS content,
        A.created_at as created_at,
        C.classify_name AS classify_name,
        C.id AS cid
        FROM articles AS A
        LEFT JOIN classifies AS C
        ON A.classify_id = C.id
        WHERE is_deleted != 1
        ORDER BY A.id 
        DESC LIMIT 5";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->execute();
    $articles_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
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
          <div class="articles col-md-9">
            <?php while($row = $articles_result->fetch_assoc()){ 
                $subject = htmlspecialchars($row['subject'], ENT_QUOTES);
                $classify_name = htmlspecialchars($row['classify_name'], ENT_QUOTES);
                $time = htmlspecialchars($row['created_at'], ENT_QUOTES);
                $content = $row['content'];
                $id = htmlspecialchars($row['id'], ENT_QUOTES);
                $cid = htmlspecialchars($row['cid'], ENT_QUOTES);
                $preview = substr($content, 0, 500);
                if(mb_strlen($preview) % 3 === 1) {
                  $preview = substr($content, 0, 500-1);
                }
                if(mb_strlen($preview) % 3 === 2) {
                  $preview = substr($content, 0, 500-2);
                }
            ?>
                <div class="article"> 
                    <div class="container"> 
                        <div class="about_article">
                            <a href="article.php?id=<?php echo $id ?>"><h2 class="title"><?php echo $subject ?></h2></a>
                            <div class="d-flex justify-content-between">
                              <div>
                                <span class="created_time me-3"><?php echo $time ?></span>
                                <span class="article_classify">分類： 
                                    <a href="classify.php?id=<?php echo $cid ?>"><?php echo $classify_name ?></a>
                                </span>
                              </div>
                              <?php if(!empty($_SESSION['id'])) {?>
                                <div class="controller_text me-3"><a class="me-3" href="editor.php?id=<?php echo $id ?>">編輯</a><a href="handle_delete.php?id=<?php echo $id ?>">刪除</a></div>
                              <?php } ?>
                            </div>
                        </div>
                        <div class="title_bottom_bar"></div>
                        <div class="content">
                            <?php echo $content ?>
                            <!-- <a class="read_more" href="article.php?id=<?php echo $id ?>">(...繼續閱讀)</a> -->
                        </div>
                    </div>
                </div>
            <?php } ?>
          </div>
          <div class="classify col-md-3 ">  
            <div class="classify container">
              
              <h3><i class="fa-solid fa-list-ul"></i> 文章分類</h3>
              <div class="title_bottom_bar"></div>
              <ul>
                <?php
                  foreach($classify_list as $classify) {
                ?>
                <li> 
                  <a href="classify.php?id=<?php echo $classify['id'] ?>">
                    <?php echo $classify['classify_name'] ?>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer>
        <div class="container d-flex align-items-center justify-content-center">
            <div class="footer_content">
                <h1>Steven's blog </h1>
                <p>about cs technology, life...</p>
            </div>
        </div>
    </footer>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>