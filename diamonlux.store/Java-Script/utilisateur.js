async function all_Utilisateur() {
    const res = await fetch('../api/all-utilisateur.php');
    const str = await res.text();
    const userList = document.getElementById('tab_users');
    userList.innerHTML = str;
}

async function searchArticle() {
    const input = document.getElementById('search-article-input');
    const name = input.value;
    if(name.length > 1) {
        const res = await fetch('../api/search-article.php?name=' + name);
        const str = await res.text();
        const articleList = document.getElementById('toutLesArticles');
        articleList.innerHTML = str;
    }    
}