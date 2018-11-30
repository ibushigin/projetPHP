<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="products.php">Products</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>

      <?php 
      if(isset($_SESSION['id'])){
            if($_SESSION['role'] === "ROLE_VENDOR"){
            ?>
            <li class="nav-item active">
            	<a class="nav-link" href="add-content.php">Modifier liste produits</a>
            </li>
            <li class="nav-item">
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
            <li class="nav-item">
            <a class="nav-link" href="index.php?deco">Déconnexion</a>
          	</li>
            <?php
            }
      }
      ?>
    </ul>
  </div>
</nav>