<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Liste des plats</title>
    <!-- Inclure Bootstrap CSS (facultatif) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclure votre fichier de style -->
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <?php include 'header.php'; ?>
    <h1 class="text-center mt-4">Liste des plats</h1>

    <div id="searchBarContainer">
        <input type="text" id="searchBar" class="form-control" placeholder="Rechercher des plats...">
    </div>

    <div class="container">
        <div class="row plat-container" id="platList">
            <!-- Les cartes de plats seront générées ici via JavaScript -->
        </div>
    </div>

    <!-- Inclure jQuery (facultatif) pour les requêtes AJAX -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Requête AJAX pour récupérer la liste des plats depuis l'API
            function fetchPlats(searchTerm = "") {
                $.ajax({
                    url: 'http://localhost/Projet_IDAW/APIs/api_plat.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        search: searchTerm
                    },
                    success: function(data) {
                        // Créez les cartes de plats à partir des données récupérées
                        $('#platList').empty(); // Supprimer le contenu existant avant d'ajouter les nouveaux plats
                        data.forEach(function(plat) {
                            var platCard = `
                                <div class="col-md-4 mb-4">
                                    <div class="card custom-card">
                                        <img src="${plat.IMAGE}" class="card-img" alt="${plat.NOM_PLAT}">
                                        <div class="card-body">
                                            <h5 class="card-title">${plat.NOM_PLAT}</h5>
                                            <button class="btn btn-primary ajouter-repas" data-idplat="${plat.ID_PLAT}" data-nomplat="${plat.NOM_PLAT}">+</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#platList').append(platCard);
                        });
                    },
                    error: function() {
                        console.log("Une erreur s'est produite lors de la récupération des données.");
                    }
                });
            }

            // Appeler fetchPlats au chargement de la page pour afficher tous les plats
            fetchPlats();

            // Gérer les changements dans la barre de recherche
            $('#searchBar').on('input', function() {
                var searchTerm = $(this).val();
                fetchPlats(searchTerm);
            });

            // Gérer le clic sur le bouton "+"
            $(document).on('click', '.ajouter-repas', function() {
                var id_plat = $(this).data('idplat');
                var nom_plat = $(this).data('nomplat');
                ajouterRepas(id_plat, nom_plat);
            });

            // Fonction pour gérer l'ajout d'un repas
            function ajouterRepas(id_plat, nom_plat) {
                var quantite = prompt(`Quantité de "${nom_plat}" :`);
                if (quantite !== null && !isNaN(quantite)) {
                    // Faites une requête AJAX pour ajouter le plat à "manger_plat" avec la quantité
                    // Utilisez l'API appropriée pour ajouter le repas
                    // Exemple :
                    $.ajax({
                        url: 'http://localhost/Projet_IDAW/APIs/api_profil.php',
                        type: 'POST',
                        data: {
                            ID_USER: <?php echo $_SESSION['id_user']; ?>, // Ajoutez cette ligne pour inclure l'ID de l'utilisateur
                            ID_PLAT: id_plat,
                            QUANTITE: quantite
                        },
                        success: function(response) {
                            console.log(response);
                            // Vous pouvez rafraîchir la liste des plats après l'ajout d'un repas si nécessaire
                            fetchPlats();
                        },
                        error: function() {
                            console.log("Une erreur s'est produite lors de l'ajout du repas.");
                        }
                    });
                }
            }

        });
    </script>
</body>

</html>