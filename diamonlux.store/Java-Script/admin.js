
async function Administration(affichage) {
    const retirerAdmin = document.getElementById('administration');
    retirerAdmin.innerHTML = "";
    const res = await fetch('../api/administration.php?affichage=' + affichage);
    const str = await res.text();
    const affichageAdmin = document.getElementById('administration');
    affichageAdmin.innerHTML = str;
}



//Pour les evenement


async function all_evenement() {
    const profil = document.getElementById('afficher_evenement');
    profil.innerHTML = "";
    const res = await fetch('../api/evenement/all-evenement.php');
    const str = await res.text();
    const userList = document.getElementById('tab_evenement');
    userList.innerHTML = str;
    
}


async function searchEvenement() {
    const input = document.getElementById('search-utilisatuer-input');
    const name = input.value;
    if(name.length > 0) {
        const profil = document.getElementById('afficher_evenement');
        profil.innerHTML = "";
        const res = await fetch('../api/evenement/search-evenement.php?name=' + name);
        const str = await res.text();
        const userList = document.getElementById('tab_evenement');
        userList.innerHTML = str;
        
    }

}

async function voir_evenement(id) {
    const res = await fetch('../api/evenement/voir-evenement.php?id=' + id);
    const str = await res.text();
    const evenement = document.getElementById('afficher_evenement');
    evenement.innerHTML = str;
}

async function supp_evenement(id){
    all_evenement();
    const res = await fetch('../api/evenement/supp_evenement.php?id=' + id);
    const str = await res.text();
    const articleList = document.getElementById('afficher_evenement');
    articleList.innerHTML = str;
    Administration('Evenement');
}

async function modif_evenement(id){
    const res = await fetch('../api/evenement/modif-evenement.php?id=' + id);
    const str = await res.text();
    const modif = document.getElementById('afficher_evenement');
    modif.innerHTML = str;

}


async function voir_participant(id) {
    const res = await fetch('../api/evenement/voir_participant.php?id=' + id);
    const str = await res.text();
    const participant = document.getElementById('afficher_evenement');
    participant.innerHTML = str;
}

async function supp_participants(idU,idE,nom,prenom) {
    const res = await fetch('../api/evenement/supp_participant.php?idU=' + idU + '&idE=' + idE +'&nom=' + nom + '&prenom=' + prenom);
    const str = await res.text();
    const msg_participant = document.getElementById('msg_conf');
    msg_participant.innerHTML = str;
    voir_participant(idE);
}

//evenement cote utilisateur

async function supp_ma_participation(idU,idE,nom,prenom) {
    const res = await fetch('../api/evenement/supp_participant.php?idU=' + idU + '&idE=' + idE +'&nom=' + nom + '&prenom=' + prenom);
    location.reload();
    
}

//Pour les articles 

async function ajouter_panier(idA,idU) {
    
    const res = await fetch('../api/article/ajouter_panier.php?idA=' + idA + '&idU=' + idU);
    const str = await res.text();
    const validation = document.getElementById('validation');
    validation.innerHTML = str;

    
}


async function voir_article(id) {
    const res = await fetch('../api/article/voir-article.php?id=' + id);
    const str = await res.text();
    const evenement = document.getElementById('afficher_article');
    evenement.innerHTML = str;
}


async function all_article_admin() {
    const profil = document.getElementById('afficher_article');
    profil.innerHTML = "";
    const res = await fetch('../api/article/all_article_admin.php');
    const str = await res.text();
    const articleList = document.getElementById('tab_article');
    articleList.innerHTML = str;
    
}


async function searchArticle_admin() {
    const input = document.getElementById('search-utilisatuer-input');
    const name = input.value;
    if(name.length > 0) {
        const profil = document.getElementById('afficher_article');
        profil.innerHTML = "";
        const res = await fetch('../api/article/search_article_admin.php?name=' + name);
        const str = await res.text();
        const articleList = document.getElementById('tab_article');
        articleList.innerHTML = str;
    }

}

async function modif_article(id){
    const res = await fetch('../api/article/modif-article.php?id=' + id);
    const str = await res.text();
    const modif = document.getElementById('afficher_article');
    modif.innerHTML = str;
   
}

async function supp_article(id){
    const res = await fetch('../api/article/supp_article.php?id=' + id);
    const str = await res.text();
    const articleList = document.getElementById('afficher_article');
    articleList.innerHTML = str;
    all_article_admin();
    
}

async function voir_commentaire(id,proprio) {
    if(proprio==-1){
        const res = await fetch('../api/article/voir-commentaire_article.php?id=' + id);
        str = await res.text();
    }else{
        const res = await fetch('../api/article/voir-commentaire_utilisateur.php?id=' + id);
        str = await res.text();
    }
    const comm = document.getElementById('afficher_article');
    comm.innerHTML = str;
}


async function supp_commentaire(id_commentaire,type) {
    const res = await fetch('../api/article/supp_commentaire.php?id_commentaire=' + id_commentaire + '&type=' + type);
    str = await res.text();
    const comm = document.getElementById('afficher_article');
    comm.innerHTML = str;
}


async function supp_commentaire_utilisateur(id_commentaire,type) {
    const res = await fetch('../api/article/supp_commentaire.php?id_commentaire=' + id_commentaire + '&type=' + type);
    location.reload();
}




//Pour les utilisateur 

async function all_Utilisateur() {
    const profil = document.getElementById('afficher_profil');
    profil.innerHTML = "";
    const res = await fetch('../api/utilisateur/all-utilisateur.php');
    const str = await res.text();
    const userList = document.getElementById('tab_users');
    userList.innerHTML = str;
}

async function searchUtilisateur() {
    const input = document.getElementById('search-utilisatuer-input');
    const name = input.value;
    if(name.length > 0) {
        const profil = document.getElementById('afficher_profil');
        profil.innerHTML = "";
        const res = await fetch('../api/utilisateur/search-utilisateur.php?name=' + name);
        const str = await res.text();
        const userList = document.getElementById('tab_users');
        userList.innerHTML = str;
    }
}

async function voir_utilisateur(id) {
    const res = await fetch('../api/utilisateur/voir-utilisateur.php?id=' + id);
    const str = await res.text();
    const profil = document.getElementById('afficher_profil');
    profil.innerHTML = str;
}

async function ban_utilisateur(id){
    const res = await fetch('../api/utilisateur/ban_utilisateur.php?id=' + id);
    all_Utilisateur();
    voir_utilisateur(id);

}

async function activer_utilisateur(id){
    const res = await fetch('../api/utilisateur/unban_utilisateur.php?id=' + id);
    all_Utilisateur();
    voir_utilisateur(id);

}

async function uppadmin_utilisateur(id){
    const res = await fetch('../api/utilisateur/uppadmin_utilisateur.php?id=' + id);
    all_Utilisateur();
    voir_utilisateur(id);

}

async function retireradmin_utilisateur(id){
    const res = await fetch('../api/utilisateur/retireradmin_utilisateur.php?id=' + id);
    all_Utilisateur();
    voir_utilisateur(id);

}

async function supp_utilisateur(id){
    const res = await fetch('../api/utilisateur/supp_utilisateur.php?id=' + id);
    all_Utilisateur();
}

//Pour les nouveaute

search_nouveaute()

async function all_nouveaute() {
    const profil = document.getElementById('afficher_nouveaute');
    profil.innerHTML = "";
    const res = await fetch('../api/nouveaute/all-nouveaute.php');
    const str = await res.text();
    const nouveauteList = document.getElementById('tab_nouveaute');
    nouveauteList.innerHTML = str;
    
}


async function search_nouveaute() {
    const input = document.getElementById('search-utilisatuer-input');
    const name = input.value;
    if(name.length > 0) {
        const profil = document.getElementById('afficher_nouveaute');
        profil.innerHTML = "";
        const res = await fetch('../api/nouveaute/search-nouveaute.php?name=' + name);
        const str = await res.text();
        const nouveauteList = document.getElementById('tab_nouveaute');
        nouveauteList.innerHTML = str;
        
    }

}

async function voir_nouveaute(id) {
    const res = await fetch('../api/nouveaute/voir-nouveaute.php?id=' + id);
    const str = await res.text();
    const voir_nouveaute = document.getElementById('afficher_nouveaute');
    voir_nouveaute.innerHTML = str;
}


async function supp_nouveaute(id){
    const res = await fetch('../api/nouveaute/supp_nouveaute.php?id=' + id);
    const str = await res.text();
    const supp_nouveaute = document.getElementById('afficher_nouveaute');
    supp_nouveaute.innerHTML = str;
    all_nouveaute();
    
}

async function modif_nouveaute(id){
    const res = await fetch('../api/nouveaute/modif-nouveaute.php?id=' + id);
    const str = await res.text();
    const modif = document.getElementById('afficher_nouveaute');
    modif.innerHTML = str;
   
}
