<nav class="header navbar navbar-expand-lg navbar-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
    <ul class="navbar-nav col-md-4">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Accueil<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="products.php">Produits</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
     </ul>

	<div class="col-md-4">
	  <h1 col-md-3">VINTAGE SHOP</h1>
	</h1>
	  <div class="col-md-4">
      <?php 
      if(isset($_SESSION['id'])){
            if($_SESSION['role'] === "ROLE_VENDOR"){
            ?>
            <li class="nav-item active">
            	<a class="nav-link" href="add-content.php">Modifier liste produits</a>
            </li>
            <li class="nav-item deconnexion">
            	<a class="nav-link" href="index.php?deco">Déconnexion</a>
          	</li>
            <?php
            }
            if($_SESSION['role'] === "ROLE_ADMIN"){
            ?>
            
            <li class="nav-item active">
              <a class="nav-link" href="add-user.php">Ajouter un utilisateur</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="add-content.php">Modifier liste produits</a>
            </li>
            <li class="nav-item ml-auto">
            <a class="nav-link" href="index.php?deco">Déconnexion</a>
          	</li>
        </div>

            <?php            
            }
      }
      ?>
	</div>
</nav>