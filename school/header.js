// ==========================================================================
// 公立杜王町大学 - 頁首專用邏輯腳本
// ==========================================================================

// 1. 自動載入頁首 HTML 結構
document.addEventListener("DOMContentLoaded", function () {
    // 尋找網頁中預留的頁首容器
    const headerContainer = document.getElementById("global-header-container");
    
    if (headerContainer) {
        // 使用 fetch 讀取獨立的 header.html
        fetch("header.html")
            .then(response => {
                if (!response.ok) {
                    throw new Error("頁首檔案載入失敗！");
                }
                return response.text();
            })
            .then(html => {
                headerContainer.innerHTML = html;
            })
            .catch(error => console.error(error));
    }
});

// 2. 歐拉！字體變大功能
let currentSizeLevel = 0;
const baseSize = 19.2;

function changeFontSize(direction) {
    if (direction === 1) {
        currentSizeLevel = (currentSizeLevel + 1) % 4;
    }
    let newSize = baseSize + (currentSizeLevel * 4);
    document.documentElement.style.fontSize = newSize + "px";
}

// 3. ⏱️ 時間停止（Za Warudo）功能
function zaWarudo() {
    const htmlEl = document.documentElement;
    htmlEl.classList.add('za-warudo-active');
    setTimeout(() => {
        htmlEl.classList.remove('za-warudo-active');
    }, 5000); // 5秒後恢復時間流動
}