<?php 
$page = $_REQUEST['page'];
sleep(2);
if($page < 5):
?>
<h1>The requested page is : <?php echo $page; ?></h1>
<h4>Top tab: <?php echo $_REQUEST['top_tab']?></h4>
<h4>Left tab: <?php echo $_REQUEST['left_tab']?></h4>

<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nisl turpis, ultricies nec imperdiet quis, ornare at nisl. Integer blandit metus vitae eros tincidunt condimentum. Sed urna est, sagittis sed commodo sit amet, ullamcorper ac massa. Duis varius ornare tellus, et pellentesque arcu consequat mollis. Vivamus quis turpis eget urna cursus sodales et accumsan elit. Vivamus nulla mauris, imperdiet vel gravida quis, faucibus rutrum mauris. Maecenas sit amet nisi vitae massa placerat eleifend vel eu lacus. Praesent et libero quis eros feugiat molestie. Mauris sit amet turpis tortor, a tempus justo. Duis interdum auctor gravida. Mauris enim risus, fringilla sit amet hendrerit sit amet, consectetur sed nulla. Mauris id viverra mauris. In hac habitasse platea dictumst. 
</p><p>
Pellentesque lacinia molestie odio, aliquam tincidunt lacus porttitor non. Cras tempus, ante nec fringilla aliquet, erat sapien rutrum lorem, a volutpat magna nunc vitae justo. In vitae ante vel sem porttitor vehicula. Vestibulum sapien neque, lobortis eget rutrum nec, imperdiet volutpat urna. Nam eget nibh non turpis luctus tempus sed sit amet eros. Nunc ultrices libero a odio accumsan fringilla vehicula turpis faucibus. Sed egestas odio at eros facilisis condimentum. Aliquam erat volutpat. Curabitur orci nisl, aliquam eu rhoncus ac, molestie lacinia est. Nunc lacinia suscipit magna, ac gravida ante adipiscing a. 
</p>

<?php endif;?>