async function supp_article_utilisateur(id) {
    const res = await fetch('../api/supp_article_utilisateur.php?id=' + id);
    const str = await res.text();
    location.reload();
    const article = document.getElementById('msg');
    article.innerHTML = str;
}

async function modif_article_utilisateur(id){
    const res = await fetch('../api/article/modif-article_utilisateur.php?id=' + id);
    const str = await res.text();
    const modif = document.getElementById('modif');
    modif.innerHTML = str;
   
}