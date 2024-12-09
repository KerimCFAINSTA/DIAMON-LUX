
async function supp_article(idA,idU) {
    const res = await fetch('../api/panier/supp_panier.php?idU=' + idU + '&idA=' + idA);
    const str = await res.text();
    
    const article_panier = document.getElementById('msg');
    article_panier.innerHTML = str;

    afficher_panier(idU)
}

async function payer_panier(id) {
    const res = await fetch('../api/panier/payer_panier.php?id=' + id);
    const str = await res.text();
    
    const payer_panier = document.getElementById('msg');
    payer_panier.innerHTML = str;

    afficher_panier(id)
}

async function afficher_panier(idU) {
    const res = await fetch('../api/panier/afficher_panier.php?idU=' + idU);
    const str = await res.text();
    
    const afficher_panier = document.getElementById('articles');
    afficher_panier.innerHTML = str;
}


