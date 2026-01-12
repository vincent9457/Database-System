
# 資訊系教師網頁維護系統

![](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) | ![](https://img.shields.io/badge/CSS-239120?&style=for-the-badge&logo=css3&logoColor=white)｜![](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

## 設計目的
> 我們選擇此一主題進行設計的目的旨在提升資訊系對內對外的資訊交流效率，並大幅簡化內容管理的流程。在前端頁面部分，我們讓系所成員的個人資料、專業領域、學術成就等資訊能夠被清晰地呈現，有助於學生、合作夥伴或業界人士能夠迅速且全面地了解資訊系的師資實力與研究方向；相較於現有系網，我們所設計的前端網頁更加直覺且擁有清晰的介面設計，以確保使用者可更快速地瀏覽並找到所需的資訊，提升資訊獲取的效率與便利性。

> 在後台管理頁面的部分，我們的核心目標在於簡化系所成員的維護流程。透過建置專屬的管理員介面與教師個人後台，我們也賦予管理人員與老師們對新增及修改自己的介紹資料有更大的自主權與彈性。管理員可以輕鬆地新增或刪除教師基本資料，確保網頁內容的即時性與資料準確性。而老師們則能藉由自行管理個人頁面內容，即時更新自己最新的研究成果、獲獎資訊或教學資料，無須透過繁瑣的申請流程。此一設計，不僅能大幅減輕管理教師資料等行政人員的負擔，也能促進系內的資訊流動。

## ER-Model
![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/ER.jpg)

## 功能展示
### 1. 前台畫面
**網站主畫面**：點擊左側標籤可更換顯示不同職位的教師 (根據職稱分類)。
![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/Homepage.png)

### 2. 前台教師資料呈現
畫面分為三部分：
基本資料、專長及學經歷、論文及參與計畫 (可展開縮合)。

![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/teacher-1.png)

![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/teacher-2.png)

### 3. 後台登入頁面
![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/back.png)

登入至管理員頁面。輸入帳號：Admin 密碼：Admin。
![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/admin.png)

### 4. 新增或編輯基本資料
![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/adminedit.png)

### 5. 註冊帳號
管理員已新增的教師可自行至註冊頁面建立帳號密碼

![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/login.png)

### 6. 教師登入畫面
左上方顯示個人資訊，右上方標籤點選可跳轉至所選段落，下方編輯課表資訊和顯示目前已輸入課表。

![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/dashboard.png)

### 7. 教師編輯資料畫面
![image](https://github.com/vincent9457/Database-System/blob/main/README_imgs/teacheredit.png)
