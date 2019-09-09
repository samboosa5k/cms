<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms/index">Derpy CMS</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php
                /* $query = "SELECT * FROM categories";
                $select_all = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all)) {
                    $cat_title = $row['cat_title'];
                    echo "<li><a href='#'>{$cat_title}</a></li>";
                } */
                ?>

                <!-- Fixed cms links -->
                <li id="contact">
                    <a href="/cms/contact">Contact</a>
                </li>
                <li id="registration">
                    <a href="/cms/registration">Registration</a>
                </li>
                <li>
                    <a href="/cms/admin">Admin</a>
                </li>
                <?php
                if ($_SESSION['role'] != null) {
                    ?>
                <li>
                    <a href="/cms/includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- SCRIPT for setting active menu links -->
<script>
    (function() {
        document.addEventListener("DOMContentLoaded", function() {
            var url = window.location.href;

            if (url.indexOf("contact") != -1) {
                document.getElementById("contact").className = "active";
            } else if (url.indexOf("registration") != -1) {
                document.getElementById("registration").className = "active";
            }
        })
    })();
</script>