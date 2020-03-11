# myframework_todo

## 環境
- php 7.3.13
- MySQL 5.6
- google chrome でしか動作を確認していません。

## 設定
1. git clone した後、config.php 内のデータベースへの接続設定を編集する。
2. データベースは新しく作るか、既に存在するものに接続する。
3. terminal$ cd myframework_todo
4. terminal$ php commands.php migrate_todos
5. terminal$ php -S localhost:8000
6. 以上でアプリを立ち上げることができると思います。

![image](https://i.gyazo.com/afa29ab1516dbe21832820635ab1f7dc.png)

## laravelを真似た機能
### Model
- models/Model.php 内に記述があります。
このクラスを継承したクラスが、all(), find($id), create($params)などのメソッドを使用できるようにしました。
次の記事を主に参考にしました。
[PHPでデータベースに接続するときのまとめ](
https://qiita.com/mpyw/items/b00b72c5c95aac573b71#html%E3%81%AE-bodybody-%E3%81%AE%E4%B8%AD%E3%81%AB%E3%83%87%E3%83%BC%E3%82%BF%E3%83%99%E3%83%BC%E3%82%B9%E6%8E%A5%E7%B6%9A%E5%87%A6%E7%90%86%E3%82%92%E6%9B%B8%E3%81%84%E3%81%A6%E3%81%84%E3%82%8Becho-%E3%82%84-print-%E3%82%92%E3%83%99%E3%82%BF%E6%9B%B8%E3%81%8D%E3%81%97%E3%81%A6%E3%81%84%E3%82%8Bcontent-type%E3%82%92-textplain-%E3%81%AB%E5%A4%89%E6%9B%B4%E3%81%9B%E3%81%9A%E3%81%AB-exit-%E3%82%84-die-%E3%81%A7%E5%BC%B7%E5%88%B6%E7%B5%82%E4%BA%86%E5%87%A6%E7%90%86%E3%82%92%E8%A8%98%E8%BF%B0%E3%81%97%E3%81%A6%E3%81%84%E3%82%8B)

- なんとか動くものにはなりましたが、エラー処理や、セキュリティのために推奨されている書き方などがよくわかりません。

### Route
- Route.php 内に同名のクラスが定義してあります。httpリクエストのurlによってコントローラーのどのメソッドを呼ぶか条件分岐させました。laravelのRoute::resource('messages', 'MessagesController');を真似ました。
- Route::get("/", function(){})のように引数に関数をとるメソッドが作れなかったので、今度してみたいです。

### Controller
- controllers/　以下にありますが、親クラスは作っていません。一つのメソッド内でviewに渡すべき変数を定義して、表示したいviewをrequireで選びます。redirectの代わりに、header関数で同じようなことができるとしりました。
- layoutの実装方法が特にわかりませんでした。

