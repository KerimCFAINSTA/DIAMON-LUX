

async function allArticle() {
    const res = await fetch('../api/article/all-article.php');
    const str = await res.text();
    const articleList = document.getElementById('toutLesArticles');
    articleList.innerHTML = str;
}

async function searchArticle() {
    const input = document.getElementById('search-article-input');
    const name = input.value;
    if(name.length > 0) {
        const res = await fetch('../api/article/search-article.php?name=' + name);
        const str = await res.text();
        const articleList = document.getElementById('toutLesArticles');
        articleList.innerHTML = str;
    }    
}