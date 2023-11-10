<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Plats Mangés par l'Utilisateur</title>
    <!-- Inclure Bootstrap CSS (facultatif) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclure DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- Inclure jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Inclure votre fichier de style personnalisé -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <h1 class="text-center mt-4">Profil</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card custom-card">
                    <div class="card-body">
                        <h1 class="card-title">Plats Mangés par l'Utilisateur</h1>
                        <table id="repasList" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nom du Plat</th>
                                    <th>Quantité (g)</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Les repas de l'utilisateur seront affichés ici via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card custom-card">
                    <div class="card-body">
                        <h5 class="card-title">Résumé Nutritionnel</h5>
                        <label for="datepicker">Sélectionner une date :</label>
                        <input type="text" id="datepicker">
                        <button class="btn btn-sm btn-warning reset-date" id="resetDate">Réinitialiser</button>
                        <div id="summary">
                            <!-- La somme des calories sera affichée ici via JavaScript -->
                        </div>
                        <div>
                            <!-- Le graphique des calories sera affiché ici -->
                            <canvas id="caloriesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclure jQuery (obligatoire pour DataTables et DatePicker) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Inclure jQuery UI JavaScript -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Inclure DataTables JavaScript -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            var caloriesChart = null;
            var table = $('#repasList').DataTable();

            // Initialiser le DatePicker
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateText) {
                    // Mettre à jour la date sélectionnée
                    selectedDate = dateText;
                    // Charger la somme des calories, le graphique et la liste des repas lorsque la date est sélectionnée
                    chargerSommeCalories(selectedDate);
                    chargerGraphiqueCalories();
                    chargerListeRepas(selectedDate); // Ajouter la date ici
                }
            });

            $('#resetDate').on('click', function() {
                // Réinitialiser la date en vidant le champ datepicker
                $("#datepicker").val("");
                // Charger la liste des repas sans filtre de date
                chargerListeRepas();
                // Réinitialiser le graphique des calories
                $("#datepicker").val(lastWeekStartFormatted);
                chargerGraphiqueCalories();

            });


            // Charger la liste des repas au chargement de la page
            chargerListeRepas();

            // Logique pour afficher par défaut les données des 7 derniers jours dans le graphique
            var today = new Date();
            var lastWeekStart = new Date(today);
            lastWeekStart.setDate(today.getDate())

            // Formater les dates au format YYYY-MM-DD
            var todayFormatted = formatDate(today);
            var lastWeekStartFormatted = formatDate(lastWeekStart);

            // Définir la date de début de la semaine par défaut dans le datepicker
            $("#datepicker").val(lastWeekStartFormatted);
            chargerGraphiqueCalories();

            function formatDate(date) {
                var yyyy = date.getFullYear().toString();
                var mm = (date.getMonth() + 1).toString().padStart(2, '0');
                var dd = date.getDate().toString().padStart(2, '0');
                return yyyy + '-' + mm + '-' + dd;
            }

            // Fonction pour charger la liste des repas
            function chargerListeRepas(date) {
                $.ajax({
                    url: 'http://localhost/Projet_IDAW/APIs/api_profil.php',
                    type: 'GET',
                    data: {
                        id_user: 0,
                        date: date // Utilisez la date ici dans la requête
                    },
                    dataType: 'json',
                    success: function(data) {
                        var repasList = [];
                        data.forEach(function(repas) {
                            var buttons = '<button class="btn btn-sm btn-primary edit" data-id="' + repas.ID_REPAS + '">Modifier</button>' +
                                '<button class="btn btn-sm btn-danger delete" data-id="' + repas.ID_REPAS + '">Supprimer</button>';

                            repasList.push([
                                repas.NOM_PLAT,
                                repas.QUANTITE,
                                repas.DATE,
                                buttons, // Ajoutez ici la colonne des boutons
                            ]);
                        });

                        // Ajouter le contenu généré dans le tableau
                        table.rows().remove().draw();
                        table.rows.add(repasList).draw();

                        // Ajouter les événements aux boutons Modifier et Supprimer
                        ajouterEvenementsBoutons();
                    },
                });
            }



            // Fonction pour ajouter les événements aux boutons Modifier et Supprimer
            function ajouterEvenementsBoutons() {
                // Événement pour le bouton Modifier
                $('.edit').on('click', function() {
                    var idRepas = $(this).data('id');
                    // Appeler une fonction qui gère la modification du repas
                    modifierRepas(idRepas);
                });

                // Événement pour le bouton Supprimer
                $('.delete').on('click', function() {
                    var idRepas = $(this).data('id');
                    // Appeler une fonction qui gère la suppression du repas
                    supprimerRepas(idRepas);
                });
            }


            // Fonction pour modifier un repas
            function modifierRepas(idRepas) {
                // Demander à l'utilisateur la nouvelle quantité et la nouvelle date
                var nouvelleQuantite = prompt("Veuillez entrer la nouvelle quantité :");
                var nouvelleDate = prompt("Veuillez entrer la nouvelle date (YYYY-MM-DD) :");

                // Assurez-vous que la quantité et la date sont valides
                if (nouvelleQuantite !== null && !isNaN(nouvelleQuantite) && nouvelleDate !== null) {
                    // Ajoutez ici le code pour appeler l'API et modifier le repas
                    // Utilisez l'API 'http://localhost/Projet_IDAW/APIs/api_profil.php' avec la méthode PUT
                    $.ajax({
                        url: 'http://localhost/Projet_IDAW/APIs/api_profil.php',
                        type: 'PUT',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            ID_REPAS: idRepas,
                            QUANTITE: nouvelleQuantite,
                            DATE: nouvelleDate
                            // Ajoutez d'autres champs si nécessaire
                        }),
                        success: function(response) {
                            // Réactualiser la liste des repas après la modification
                            chargerListeRepas();
                            console.log(response);
                        },
                        error: function(error) {
                            console.log("Une erreur s'est produite lors de la modification du repas.");
                            console.log(error);
                        }
                    });
                } else {
                    alert("Veuillez entrer une quantité et une date valides.");
                }
            }


            // Fonction pour supprimer un repas
            function supprimerRepas(idRepas) {
                // Demander confirmation à l'utilisateur
                var confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce repas ?");
                if (confirmation) {
                    // Ajoutez ici le code pour appeler l'API et supprimer le repas
                    // Utilisez l'API 'http://localhost/Projet_IDAW/APIs/api_profil.php' avec la méthode DELETE
                    $.ajax({
                        url: 'http://localhost/Projet_IDAW/APIs/api_profil.php?ID_REPAS=' + idRepas,
                        type: 'DELETE',
                        success: function(response) {
                            // Réactualiser la liste des repas après la suppression
                            chargerListeRepas();
                            console.log(response);
                        },
                        error: function(error) {
                            console.log("Une erreur s'est produite lors de la suppression du repas.");
                            console.log(error);
                        }
                    });
                }
            }



            // Fonction pour charger la somme des calories
            function chargerSommeCalories(date) {
                $.ajax({
                    url: 'http://localhost/Projet_IDAW/APIs/api_calories.php', // URL de l'API
                    type: 'GET',
                    data: {
                        id_user: 0,
                        date: date
                    },
                    success: function(data) {
                        // Afficher la somme des calories dans la div
                        $('#summary').html('<p>Total des calories consommées ce jour : ' + data + ' kcal</p>');
                    },
                    error: function() {
                        console.log("Une erreur s'est produite lors de la récupération des calories.");
                    }
                });
            }

            // Fonction pour charger le graphique des calories
            function chargerGraphiqueCalories() {
                var selectedDate = $("#datepicker").val();

                // Créer un tableau de 7 jours incluant la date sélectionnée
                var dateArray = [];
                for (var i = 6; i >= 0; i--) {
                    var currentDate = new Date(selectedDate);
                    currentDate.setDate(currentDate.getDate() - i);
                    dateArray.push(currentDate.toISOString().split('T')[0]);
                }

                // Appeler l'API pour récupérer les totaux des calories pour chaque jour
                var promises = dateArray.map(function(date) {
                    return new Promise(function(resolve, reject) {
                        $.ajax({
                            url: 'http://localhost/Projet_IDAW/APIs/api_calories.php',
                            type: 'GET',
                            data: {
                                id_user: 0,
                                date: date
                            },
                            success: function(data) {
                                resolve(data);
                            },
                            error: function() {
                                reject(new Error("Une erreur s'est produite lors de la récupération des données du graphique."));
                            }
                        });
                    });
                });

                // Utiliser Promise.all pour attendre que toutes les promises soient résolues
                Promise.all(promises)
                    .then(function(results) {
                        // Toutes les données sont récupérées, créer le graphique
                        creerGraphiqueCalories(dateArray, results);
                    })
                    .catch(function(error) {
                        console.log(error.message);
                    });
            }

            // Fonction pour créer le graphique des calories
            function creerGraphiqueCalories(dates, calories) {
                // Récupérer l'élément canvas et son contexte
                var ctx = document.getElementById('caloriesChart').getContext('2d');

                // Supprimer le graphique existant s'il y en a un
                if (caloriesChart !== null) {
                    caloriesChart.destroy();
                }

                // Créer un nouveau graphique en utilisant Chart.js
                caloriesChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Calories consommées',
                            data: calories,
                            backgroundColor: 'rgba(46, 204, 113, 0.2)', // Vert clair
                            borderColor: 'rgba(46, 204, 113, 1)', // Vert foncé
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            x: [{
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    displayFormats: {
                                        day: 'MMM DD'
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }],
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Calories'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>