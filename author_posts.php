<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>

    
 
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            
            <div class="col-md-8">
               
             <?php

      

             $per_page = 10;


            if(isset($_GET['page'])) {


            $page = $_GET['page'];

            } else {


                $page = "";
            }


            if($page == "" || $page == 1) {

                $page_1 = 0;

            } else {

                $page_1 = ($page * $per_page) - $per_page;

            }


         if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ) {


        $post_query_count = "SELECT * FROM posts";


         } else {

         $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";

         }   

        $find_count = mysqli_query($connection,$post_query_count);
        $count = mysqli_num_rows($find_count);

        if($count < 1) {


            echo "<h1 class='text-center'>No posts available</h1>";




        } else {


        $count  = ceil($count /$per_page);

            
            
            

            if(isset($_GET['p_id'])){
                $the_post_id    =$_GET['p_id'];
                $the_post_author=$_GET['author'];
                
            }
                
        $query = "SELECT * FROM posts WHERE post_user='{$the_post_author}' ";
//            LIMIT $page_1, $per_page";
        $select_all_posts_query = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_all_posts_query)) {
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_user'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = substr($row['post_content'],0,400);
        $post_status = $row['post_status'];
        

    
        ?>
        
        
        
         <!-- Page Heading -->
                
                    
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

                 


                <!-- First Blog Post -->

              

                <h2>
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    All posts by <?php echo $post_author ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                
                
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
                </a>
                
                
                
                <hr>
                <p><?php echo $post_content ?></p>
               

                <hr>
                
                
                

   <?php }  } ?>

                
                
                
                   <!-- Blog Comments -->
                   
                   <?php
                      if(isset($_POST['create_comment']))
                      {
                          $the_post_id=$_GET['p_id'];
                          
                          $comment_author=$_POST['comment_author'];
                          $comment_email=$_POST['comment_email'];
                          $comment_content=$_POST['comment_content'];
                          
                          if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

$query="INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) ";
$query.="VALUES($the_post_id,'{$comment_author}','{$comment_email}','{$comment_content}','unapproved',now())";
                          
                          $create_comment_query=mysqli_query($connection,$query);
                          if(!$create_comment_query){
                              
                              echo "Query Failed".mysqli_error($connection);
                          }
                        
$query="UPDATE posts SET post_comment_count = post_comment_count + 1 ";
$query.="WHERE post_id=$the_post_id ";
$update_comment_count=mysqli_query($connection,$query);                      
                          
                          
                          }
                           else   
                          {
                             echo "<script>alert('Field can not be empty')</script>" ;
                          }
                          
                      }
                
                
         
 ?>
       
    
    

            </div>
            
              

            <!-- Blog Sidebar Widgets Column -->
            
            
            <?php include "includes/sidebar.php";?>
             

        </div>
        <!-- /.row -->

        <hr>


        <ul class="pager">

        <?php 

        $number_list = array();


        for($i =1; $i <= $count; $i++) {


        if($i == $page) {

             echo "<li '><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";


        }  else {

            echo "<li '><a href='index.php?page={$i}'>{$i}</a></li>";



        
         

        }

        
        



           
        }






         ?>
            




        </ul>

   

<?php include "includes/footer.php";?>
