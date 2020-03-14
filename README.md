# myframework2

## 環境
- php 7.3.13
- MySQL 5.6
- google chrome でしか動作を確認していません。

## 設定
1. git clone した後、config.php 内のデータベースへの接続設定を編集する。
2. データベースは新しく作るか、既に存在するものに接続する。
3. shell> cd myframework2
4. shell> composer install
composerのオートローダーを使用しています
5. shell> php exec serve
6. shell> php exec migrate
7. 以上でアプリを立ち上げることができると思います。

![image](https://i.gyazo.com/afa29ab1516dbe21832820635ab1f7dc.png)

## laravelを真似た機能
### Model
- app/Models/Model.php 内に記述があります。
このクラスを継承したクラスが、all(), find($id), create($params)などのメソッドを使用できるようにしました。


### Route
- libs/Routing/ 内にRouteクラスとRouteListクラスが定義してあります。


### Controller
- app/Controllers/ 以下にありますが、親クラスは作っていません。


