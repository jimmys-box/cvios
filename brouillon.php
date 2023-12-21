<?php

// Déclaration de la fonction d'ajout des meta données
function capvert_gms_intervention_ajouter(WP_REST_Request $request) {

    $donnees = $request->get_query_params();

    // Récupération des valeurs des paramètres du chantier et des collaborateurs intervenant sur celui-ci
    $idChantier = $donnees['idchantier'];
    $id_equipe = get_field("id_equipe", $idChantier);
    // Initialisation des extras de nettoyage de portiques de lavage
    if (isset($donnees['extraportiquesdelavage'])) {
        $extraNbPortiquesLavages = $donnees['extraportiquesdelavage'];
        if ($extraNbPortiquesLavages == "rien") {
            $extraNbPortiquesLavages = "0";
        }
    } else {
        $extraNbPortiquesLavages = "";a:
    }

 // Initialisation des extras de nettoyage de portiques de lavage
 if (isset($donnees['extracaracteristiquesdelastationservice'])) {
    $extraCaracteristiquesDeLaStationService = $donnees['extracaracteristiquesdelastationservice'];
    if ($extraCaracteristiquesDeLaStationService == "rien") {
        $extraCaracteristiquesDeLaStationService = "0";
    }
} else {
    $extraCaracteristiquesDeLaStationService = get_field("caracteristiques_de_la_station_service", $idChantier);
}
    // Initialisation des extras de nettoyage des pistes haute pression
    if (isset($donnees['extrapisteshautepression'])) {
        $extraNbPistesHautePression = $donnees['extrapisteshautepression'];
        if ($extraNbPistesHautePression == "rien") {
            $extraNbPistesHautePression = "0";
        }
    } else {
        $extraNbPistesHautePression =get_field( 'nombre_de_pistes_haute_pression', $idChantier );
    }

    // Initialisation des extras de nettoyage des totems
    if (isset($donnees['extratotem'])) {
        $extraTotem = $donnees['extratotem'];
        if ($extraTotem == "rien") {
            $extraTotem = "0";
        }
    } else {
        $extraTotem = get_field( 'totem', $idChantier );
    }

    // Initialisation des extras de nettoyage des abris à chariots doubles
    if (isset($donnees['extraabrischariotsdoubles'])) {
        $extraAbrisChariotsDoubles = $donnees['extraabrischariotsdoubles'];
        if ($extraAbrisChariotsDoubles == "rien") {
            $extraAbrisChariotsDoubles = "0";
        }
    } else {
        $extraAbrisChariotsDoubles = get_field( 'nombre_dabris_chariots_doubles', $idChantier );
    }

    // Initialisation des extras de nettoyage des abris à chariots simples
    if (isset($donnees['extraabrischariotssimples'])) {
        $extraAbrisChariotsSimples = $donnees['extraabrischariotssimples'];
        if ($extraAbrisChariotsSimples == "rien") {
            $extraAbrisChariotsSimples = "0";
        }
    } else {
        $extraAbrisChariotsSimples = get_field( 'nombre_dabris_chariots_simples', $idChantier );
    }

    // Initialisation des extras de nettoyage des pistes de gonflage ou d'aspiration
    if (isset($donnees['extraairesaspirateurgonflage'])) {
        $extraAiresAspirateurGonflage = $donnees['extraairesaspirateurgonflage'];
        if ($extraAiresAspirateurGonflage == "rien") {
            $extraAiresAspirateurGonflage = "0";
        }
    } else {
        $extraAiresAspirateurGonflage = get_field( 'nombre_daires_aspirateur_gonflage', $idChantier );
    }

    // Initialisation des extras de nettoyage des entrées de magasin
    if (isset($donnees['extraentreesdemagasin'])) {
        $extraEntreesDeMagasin = $donnees['extraentreesdemagasin'];
        if ($extraEntreesDeMagasin == "rien") {
            $extraEntreesDeMagasin = "0";
        }
    } else {
        $extraEntreesDeMagasin = get_field( 'nombre_entrees_de_magasin', $idChantier );
    }

    // Initialisation des extras de nettoyage des hauteurs de bardage
    if (isset($donnees['extrahauteurdubardage'])) {
        $extraHauteurDeBardage = $donnees['extrahauteurdubardage'];
        if ($extraHauteurDeBardage == "rien") {
            $extraHauteurDeBardage = "0";
        }
    } else {
        $extraHauteurDeBardage = get_field( 'hauteur_du_bardage', $idChantier );
    }

    // Initialisation des notes de précision pour l'intervention
    if (isset($donnees['notesprecisionsintervention'])) {
        $notesPrecisionsIntervention = $donnees['notesprecisionsintervention'];
        if (empty($notesPrecisionsIntervention)) {
            $notesPrecisionsIntervention = "";
        }
    } else {
        $notesPrecisionsIntervention = get_field("commentaires", $idChantier);
        if (empty($notesPrecisionsIntervention)) {
            $notesPrecisionsIntervention = "";
        }
    }

    // Initialisation de la date de début d'intervention
    if (isset($donnees['datedebutintervention'])) {
        $date_debut_intervention = $donnees['datedebutintervention'];
        if ($date_debut_intervention == "rien") {
            $date_debut_intervention = "0";
        } else if (!empty($date_debut_intervention)) {
            $date_choisie = $date_debut_intervention;
        }
    } else {
        $date_debut_intervention = "";
    }

    // Initialisation de la date de début d'intervention
    if (isset($donnees['dateintervention'])) {
        $date_intervention = $donnees['dateintervention'];
        if ($date_intervention == "rien") {
            $date_intervention = "0";
        } else if (!empty($date_intervention)) {
            $date_choisie = $date_intervention;
        }
    } else {
        $date_intervention = "";
    }

    // Initialisation de la date de fin d'intervention
    if (isset($donnees['datefinintervention'])) {
        $date_fin_intervention = $donnees['datefinintervention'];
        if ($date_fin_intervention == "rien") {
            $date_fin_intervention = "0";
        }
    } else {
        $date_fin_intervention = "";
    }

    // Initialisation de la variable de changement manuel
    if (isset($donnees['changementmanuel'])) {
        $changementManuelTemp = $donnees['changementmanuel'];

        if ($changementManuelTemp == "1" || $changementManuel == 1) {
            $changementManuel = true;
        }
    } else {
        $changementManuel = false;
    }

    // Initialisation de la variable de changement manuel
    if (isset($donnees['idequipe'])) {
        $id_equipe = $donnees['idequipe'];
    }

    // Initialisation de la variable de changement manuel
    if (isset($donnees['statutintervention'])) {
        $statut_intervention = $donnees['statutintervention'];
    } else {
        $statut_intervention = "prévue";
    }


    if (isset($donnees['emailrapport'])) {
        $email_rapport = $donnees['emailrapport'];
    } else {
        $email_rapport = "";
    }


    if (isset($donnees['interventionunique'])) {
        $intervention_unique = $donnees['interventionunique'];
    } else {
        $intervention_unique = "";
    }
    

    // Récupération de la grille tarifaire adaptée à l'intervention //

    // Vérification de l'existence d'une grille tarifaire spécifique au chantier
    $basePortiquesLavage = get_field("nombre_de_portiques_de_lavage", $idChantier);
    $tarifPortiquesLavage = get_field("tarif_de_base_portiques_de_lavage", $idChantier);

    $basePistesHautePression = get_field("nombre_de_pistes_haute_pression", $idChantier);
    $tarifPistesHautePression = get_field("tarif_de_base_pistes_haute_pression", $idChantier);

    $baseTotem = get_field("totem", $idChantier);
    $tarifTotem = get_field("tarif_de_base_totem", $idChantier);

    $baseAbrisChariotsSimples = get_field("nombre_dabris_chariots_simples", $idChantier);
    $tarifAbrisChariotsSimples = get_field("tarif_de_base_abris_chariots_simples", $idChantier);

    $baseAbrisChariotsDoubles = get_field("nombre_dabris_chariots_doubles", $idChantier);
    $tarifAbrisChariotsDoubles = get_field("tarif_de_base_abris_chariots_doubles", $idChantier);

    $baseAiresAspirateurGonflage = get_field("nombre_daires_aspirateur_gonflage", $idChantier);
    $tarifAiresAspirateurGonflage = get_field("tarif_de_base_aires_aspirateur_gonflage", $idChantier);

    $baseEntreesDeMagasin = get_field("nombre_entrees_de_magasin", $idChantier);
    $tarifEntreesDeMagasin = get_field("tarif_de_base_entree_de_magasin", $idChantier);

    $baseHauteurDeBardage = get_field("hauteur_du_bardage", $idChantier);
    $tarifHauteurDeBardage = get_field("tarif_de_base_metre_hauteur_du_bardage", $idChantier);
    
    // if (!isset($id_equipe)) {
    //     $id_equipe = get_field("id_equipe", $idChantier);
    // }

    // Déclaration de la valeur de l'ID du custom post type gérant la grille tarifaire standardisée
    $idGrilleTarifaire = 2709;

    if (empty($tarifPortiquesLavage) || $tarifPortiquesLavage == "0" || $tarifPortiquesLavage == 0) {
        $tarifPortiquesLavage = get_field("tarif_standard_portiques_de_lavage", $idGrilleTarifaire);
    }
    
    if (empty($tarifPistesHautePression) || $tarifPistesHautePression == "0" || $tarifPistesHautePression == 0) {
        $tarifPistesHautePression = get_field("tarif_standard_pistes_haute_pression", $idGrilleTarifaire);
    }

    if (empty($tarifTotem) || $tarifTotem == "0" || $tarifTotem == 0) {
        $tarifTotem = get_field("tarif_standard_totem", $idGrilleTarifaire);
    }

    if (empty($tarifAbrisChariotsSimples) || $tarifAbrisChariotsSimples == "0" || $tarifAbrisChariotsSimples == 0) {
        $tarifAbrisChariotsSimples = get_field("tarif_standard_abris_chariots_simples", $idGrilleTarifaire);
    }

    if (empty($tarifAbrisChariotsDoubles) || $tarifAbrisChariotsDoubles == "0" || $tarifAbrisChariotsDoubles == 0) {
        $tarifAbrisChariotsDoubles = get_field("tarif_standard_abris_chariots_doubles", $idGrilleTarifaire);
    }

    if (empty($tarifAiresAspirateurGonflage) || $tarifAiresAspirateurGonflage == "0" || $tarifAiresAspirateurGonflage == 0) {
        $tarifAiresAspirateurGonflage = get_field("tarif_standard_aires_aspirateur_gonflage", $idGrilleTarifaire);
    }

    if (empty($tarifEntreesDeMagasin) || $tarifEntreesDeMagasin == "0" || $tarifEntreesDeMagasin == 0) {
        $tarifEntreesDeMagasin = get_field("tarif_standard_entree_de_magasin", $idGrilleTarifaire);
    }

    if (empty($tarifHauteurDeBardage) || $tarifHauteurDeBardage == "0" || $tarifHauteurDeBardage == 0) {
        $tarifHauteurDeBardage = get_field("tarif_standard_metre_hauteur_du_bardage", $idGrilleTarifaire);
    }

    if (empty($email_rapport) || $email_rapport == "" || $email_rapport == null) {
        $email_rapport = "";
    }


    // Initialisation de la variable de changement manuel
    if (isset($donnees['cahtextratotal'])) {
        $caHtExtraTotal = $donnees['cahtextratotal'];
        if ($caHtExtraTotal == "rien") {
            $caHtExtraTotal = "0";
        }
    } else {
        $caHtExtraTotal = "";
    }

    // Initialisation de la variable de changement manuel
    if (isset($donnees['extratotems'])) {
        $extraTotems = $donnees['extratotems'];
        if ($extraTotems == "rien") {
            $extraTotems = "0";
        } else if (empty($extraTotems)) {
            $extraTotems = "";
        }
    } else {
        $extraTotems = "";
    }
    if(empty($extraTotems)) {
        $extraTotems = "";
    }

    $caHtBase = get_field("ca_ht", $idChantier);
    // Initialisation de la variable de changement manuel
    if (isset($donnees['cahttotal'])) {
        $caHtTotal = $donnees['cahttotal'];
        if ($caHtTotal == "rien") {
            $caHtTotal = "0";
        }
    } else {
        $caHtTotal = $caHtBase;
    }

    $cpChantier = get_field("code_postal_commercial", $idChantier);
    if (empty($cpChantier)) {
        $cpChantier = "";
    }

    $villeChantier = get_field("ville_commercial", $idChantier);
    if (empty($villeChantier)) {
        $villeChantier = "";
    }

    $nom_equipe = get_field("nom_equipe", $id_equipe);
    if (empty($nom_equipe)) {
        $nom_equipe = "";
    }
    

    $acces_eau_intervention = $donnees["acceseau"];
    if (empty($acces_eau_intervention)) {
        $acces_eau_intervention = "";
    }

    $caracteristiques_de_la_station_service_intervention = $donnees["caracteristiquesdelastationservice"];
    if (empty($caracteristiques_de_la_station_service_intervention)) {
        $caracteristiques_de_la_station_service_intervention = "";
    }

    $type_auvent_intervention = $donnees["typeauvent"];
    if (empty($type_auvent_intervention)) {
        $type_auvent_intervention = "";
    }

    $nettoyabilite_toiture_intervention = $donnees["nettoyabilitetoiture"];
    if (empty($nettoyabilite_toiture_intervention)) {
        $nettoyabilite_toiture_intervention = "";
    }

    $visibilite_gouttiere_intervention = $donnees["visibilitegouttiere"];
    if (empty($visibilite_gouttiere_intervention)) {
        $visibilite_gouttiere_intervention = "";
    }

    $interdiction_dintervention_intervention = $donnees["interdictiondintervention"];
    if (empty($interdiction_dintervention_intervention)) {
        $interdiction_dintervention_intervention = "";
    }

    // $totalExtraPortiquesLavages = ($extraAbrisChariotsDoubles * $tarifPortiquesLavage);
    // $totalExtraPistesHautePression = ($extraNbPistesHautePression * $tarifPistesHautePression);
    // $totalExtraTotems = ($extraTotems * $tarifTotem);
    // $totalExtraAbrisChariotsSimples = ($extraAbrisChariotsSimples * $tarifAbrisChariotsSimples);
    // $totalExtraAbrisChariotsDoubles = ($extraAbrisChariotsDoubles * $tarifAbrisChariotsDoubles);
    // $totalExtraAiresAspirateurGonflage = ($extraAiresAspirateurGonflage * $tarifAiresAspirateurGonflage);
    // $totalExtraEntreesDeMagasin = ($extraEntreesDeMagasin * $tarifEntreesDeMagasin);
    // $totalExtraHauteurDeBardage = ($extraHauteurDeBardage * $tarifHauteurDeBardage);

    // $caHtExtraTotal = $totalExtraPortiquesLavages + $totalExtraPistesHautePression + $totalExtraTotems + $totalExtraAbrisChariotsSimples + $totalExtraAbrisChariotsDoubles + $totalExtraAiresAspirateurGonflage + $totalExtraEntreesDeMagasin + $totalExtraHauteurDeBardage;


    $acces_eau_chantier = get_field("acces_eau", $idChantier);

    $caracteristiques_de_la_station_service_chantier = get_field("caracteristiques_de_la_station_service", $idChantier);
    if(empty($interdiction_dintervention)) {
        $interdiction_dintervention = "";
    }

    $type_auvent_chantier = get_field("type_auvent", $idChantier);
    if(empty($interdiction_dintervention)) {
        $interdiction_dintervention = "";
    }

    $nettoyabilite_toiture_chantier = get_field("nettoyabilite_toiture", $idChantier);
    if(empty($interdiction_dintervention)) {
        $interdiction_dintervention = "";
    }

    $visibilite_gouttiere_chantier = get_field("visibilite_gouttiere", $idChantier);
    if(empty($interdiction_dintervention)) {
        $interdiction_dintervention = "";
    }

    $interdiction_dintervention_chantier = get_field("interdiction_dintervention", $idChantier);
    if(empty($interdiction_dintervention)) {
        $interdiction_dintervention = "";
    }

    $extraPrestations = array(
        (object) [
                "type" => "acces_eau",
                "nombre_base" => $acces_eau_chantier,
                "nombre_supplementaire" => $acces_eau_intervention,
                "tarif_de_base" => "",
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "caracteristiques_de_la_station_service",
                "nombre_base" => $caracteristiques_de_la_station_service_chantier,
                "nombre_supplementaire" => $extraCaracteristiquesDeLaStationService,
                "tarif_de_base" => "",
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "type_auvent",
                "nombre_base" => $type_auvent_chantier,
                "nombre_supplementaire" => $type_auvent_intervention,
                "tarif_de_base" => "",
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "nettoyabilite_toiture",
                "nombre_base" => $nettoyabilite_toiture_chantier,
                "nombre_supplementaire" => $nettoyabilite_toiture_intervention,
                "tarif_de_base" => "",
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "visibilite_gouttiere",
                "nombre_base" => $visibilite_gouttiere_chantier,
                "nombre_supplementaire" => $visibilite_gouttiere_intervention,
                "tarif_de_base" => "",
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "interdiction_dintervention",
                "nombre_base" => $interdiction_dintervention_chantier,
                "nombre_supplementaire" => $interdiction_dintervention_intervention,
                "tarif_de_base" => "",
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "portiques de lavage",
                "nombre_base" => $basePortiquesLavage,
                // "nombre_base" => $extraNbPortiquesLavages,
                "nombre_supplementaire" => $extraNbPortiquesLavages,
                "tarif_de_base" => $tarifPortiquesLavage,
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "pistes haute pression",
                "nombre_base" => $basePistesHautePression,
                // "nombre_base" => $extraNbPistesHautePression,
                "nombre_supplementaire" => $extraNbPistesHautePression,
                "tarif_de_base" => $tarifPistesHautePression,
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "totems",
                "nombre_base" => $baseTotem,
                // "nombre_base" => $extraTotems,
                "nombre_supplementaire" => $extraTotems,
                "tarif_de_base" => $tarifTotem,
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "abris à chariots simples",
                "nombre_base" => $baseAbrisChariotsSimples,
                // "nombre_base" => $extraAbrisChariotsSimples,
                "nombre_supplementaire" => $extraAbrisChariotsSimples,
                "tarif_de_base" => $tarifAbrisChariotsSimples,
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "abris à chariots doubles",
                "nombre_base" => $baseAbrisChariotsDoubles,
                // "nombre_base" => $extraAbrisChariotsDoubles,
                "nombre_supplementaire" => $extraAbrisChariotsDoubles,
                "tarif_de_base" => $tarifAbrisChariotsDoubles,
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "aires d'aspiration ou de gonflage",
                "nombre_base" => $baseAiresAspirateurGonflage,
                // "nombre_base" => $extraAiresAspirateurGonflage,
                "nombre_supplementaire" => $extraAiresAspirateurGonflage,
                "tarif_de_base" => $tarifAiresAspirateurGonflage,
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "entrées de magasin",
                "nombre_base" => $baseEntreesDeMagasin,
                // "nombre_base" => $extraEntreesDeMagasin,
                "nombre_supplementaire" => $extraEntreesDeMagasin,
                "tarif_de_base" => $tarifEntreesDeMagasin,
                "ca_ht_supplementaire" => ""
        ],
        (object) [
                "type" => "mètres de hauteur de bardage",
                "nombre_base" => $baseHauteurDeBardage,
                // "nombre_base" => $extraHauteurDeBardage,
                "nombre_supplementaire" => $extraHauteurDeBardage,
                "tarif_de_base" => $tarifHauteurDeBardage,
                "ca_ht_supplementaire" => ""
        ]
    );

    // $caHtTotal = $caHtBase + $caHtExtraTotal;

    $titre = "Intervention sur chantier GMS {$idChantier}";
    $contenu = "[fiche_intervention]";

    $idIntervention = wp_insert_post(array (
        'post_content' => $contenu,
        'post_title' => $titre,
        'post_type' => 'interventiongms',
        'post_status' => 'publish'
    ));
    
    if ($idIntervention) {

        // Mise à jour du champ concernant la liste des collaborateur pour la fiche intervention //
        update_field("id_chantier", $idChantier, $idIntervention);
        update_field("changement_manuel", $changementManuel, $idIntervention);
        update_field("total_ca_ht_avec_extra", $caHtTotal, $idIntervention);
        update_field("extra_portiques_de_lavage", $extraNbPortiquesLavages, $idIntervention);
        update_field("extra_caracteristiques_de_la_station_service", $extraCaracteristiquesDeLaStationService, $idIntervention);
        update_field("extra_pistes_haute_pression", $extraNbPistesHautePression, $idIntervention);
        update_field("extra_totem", $extraTotem, $idIntervention);
        update_field("extra_abris_chariots_simples", $extraAbrisChariotsSimples, $idIntervention);
        update_field("extra_abris_chariots_doubles", $extraAbrisChariotsDoubles, $idIntervention);
        update_field("extra_aires_aspirateur_gonflage", $extraAiresAspirateurGonflage, $idIntervention);
        update_field("extra_entrees_de_magasin", $extraEntreesDeMagasin, $idIntervention);
        update_field("extra_hauteur_du_bardage", $extraHauteurDeBardage, $idIntervention);
        update_field("statut_intervention", "prevue", $idIntervention);
        update_field("notes_precisions_intervention", $notesPrecisionsIntervention, $idIntervention);
        update_field("date_intervention", $date_intervention, $idIntervention);
        update_field("date_debut_intervention", $date_debut_intervention, $idIntervention);
        update_field("date_fin_intervention", $date_fin_intervention, $idIntervention);
        update_field("id_equipe", $id_equipe, $idIntervention);
        update_field("statut_intervention", $statut_intervention, $idIntervention);
        update_field("email_rapport", $email_rapport, $idIntervention);
        update_field("intervention_unique", $intervention_unique, $idIntervention);

        // $equipierTemp = array();

        // foreach ($listeEquipiersFiltree as $equipier) {
        //     array_push($equipierTemp, (object) [
        //         "id_collaborateur" => $equipier
        //     ]);
        // }

        // Récupération des données du chantier
        $adresseChantier = get_field("adresse_du_chantier", $idChantier);
        $dateDeDernierNettoyage = get_field("date_de_dernier_nettoyage", $idChantier);
        $frequenceDeNettoyage = get_field("frequence_de_nettoyage", $idChantier);

        if (empty($adresseChantier)) {
            $adresseChantier = "";
        }

        if (empty($dateDeDernierNettoyage)) {
            $dateDeDernierNettoyage = "";
        }

        if (empty($frequenceDeNettoyage)) {
            $frequenceDeNettoyage = "";
        }
        
        if (!empty($date_choisie)) {
            $tableau_dates_futures = orga_chantier_avec_date($idChantier, $changementManuel, "gms", $date_choisie, $intervention_unique);

            if (gettype($tableau_dates_futures) == "string") {
                $liste_dates_futures_interventions = "";
                $liste_id_futures = "";
            } else {
                $date_inter = $date_choisie;

                update_field("date_intervention", $date_inter, $idIntervention);
                update_field("date_debut_intervention", $date_inter, $idIntervention);
    
                $taille_tableau_dates = count($tableau_dates_futures);
    
                $liste_id_futures = array();
            }
            
        } else {
            $date_inter = "";
            $tableau_dates_futures = ["aucune date"];
        }

        if ($tableau_dates_futures == $date_choisie) {
            $liste_dates_futures_interventions = $date_choisie;
            $liste_id_futures = "";
        } else {

            for ($i = 0; $i < $taille_tableau_dates; $i++) {

                $date_inter_future = $tableau_dates_futures[$i];
                $date_debut_inter_future = $tableau_dates_futures[$i];
    
                $titre_future = "Intervention sur chantier GMS {$idChantier}";
                $contenu_future = "[fiche_intervention]";
    
                $id_int_future = wp_insert_post(array (
                    'post_content' => $contenu_future,
                    'post_title' => $titre_future,
                    'post_type' => 'interventiongms',
                    'post_status' => 'publish'
                ));
        
                if ($id_int_future) {
    
                    // Mise à jour du champ concernant la liste des collaborateur pour la fiche intervention //
                    update_field("id_chantier", $idChantier, $id_int_future);
                    // update_field("liste_equipiers", $listeEquipiers, $idIntervention);
                    update_field("changement_manuel", $changementManuel, $id_int_future);
                    update_field("total_ca_ht_avec_extra", $caHtTotal, $id_int_future);
                    update_field("extra_portiques_de_lavage", $extraNbPortiquesLavages, $id_int_future);
                    update_field("extra_caracteristiques_de_la_station_service", $extraCaracteristiquesDeLaStationService, $id_int_future);
                    update_field("extra_pistes_haute_pression", $extraNbPistesHautePression, $id_int_future);
                    update_field("extra_totem", $extraTotem, $id_int_future);
                    update_field("extra_abris_chariots_simples", $extraAbrisChariotsSimples, $id_int_future);
                    update_field("extra_abris_chariots_doubles", $extraAbrisChariotsDoubles, $id_int_future);
                    update_field("extra_aires_aspirateur_gonflage", $extraAiresAspirateurGonflage, $id_int_future);
                    update_field("extra_entrees_de_magasin", $extraEntreesDeMagasin, $id_int_future);
                    update_field("extra_hauteur_du_bardage", $extraHauteurDeBardage, $id_int_future);
                    update_field("statut_intervention", "prevue", $id_int_future);
                    update_field("notes_precisions_intervention", $notesPrecisionsIntervention, $id_int_future);
                    update_field("date_intervention", $date_inter_future, $id_int_future);
                    update_field("date_debut_intervention", $date_debut_inter_future, $id_int_future);
                    update_field("date_fin_intervention", $date_fin_intervention, $id_int_future);
                    update_field("id_equipe", $id_equipe, $id_int_future);
                    update_field("statut_intervention", $statut_intervention, $id_int_future);
                    update_field("email_rapport", $email_rapport, $id_int_future);
                    update_field("intervention_unique", $intervention_unique, $id_int_future);
    
                    // Récupération des données du chantier
                    $adresseChantier = get_field("adresse_du_chantier", $idChantier);
                    $dateDeDernierNettoyage = get_field("date_de_dernier_nettoyage", $idChantier);
                    $frequenceDeNettoyage = get_field("frequence_de_nettoyage", $idChantier);
    
                    $date_inter = $date_inter_future;
    
                    update_field("date_intervention", $date_inter, $id_int_future);
                    update_field("date_debut_intervention", $date_inter, $id_int_future);
    
                    array_push($liste_id_futures, $id_int_future);
                
                }
            }
            $liste_dates_futures_interventions = $tableau_dates_futures;
        }
       
    }


	$reponse = array(
		(object) [
            'id' => $idIntervention,
            'id_chantier_associe' => $idChantier,
            'code_postal_chantier' => $cpChantier,
            'ville_chantier' => $villeChantier,
            'adresse_chantier' => $adresseChantier,
            'date_intervention' => $date_inter,
            'date_debut_intervention' => $date_inter,
            'date_fin_intervention' => $date_fin_intervention,
            'ca_ht_prestations_extra' => $caHtExtraTotal,
            'ca_ht_total_intervention' => $caHtTotal,
            'changement_manuel' => $changementManuel,
            'notes_precisions_intervention' => $notesPrecisionsIntervention,
            'frequence_de_nettoyage' => $frequenceDeNettoyage,
			// // // 'liste_equipiers' => (object) [
            // // //     $equipiers
            // // // ],
            'id_equipe' => $id_equipe,
            'nom_equipe' => $nom_equipe,
            'statut_intervention' => $statut_intervention,
            // // 'liste_equipier_parametre_string' => $listeEquipiers,
            'prestations' => $extraPrestations,
            'email_rapport' => $email_rapport,
            'liste_dates_futures_interventions' => $liste_dates_futures_interventions,
            'liste_id_futures_interventions' => $liste_id_futures
        ]
	);

    return $reponse;
}