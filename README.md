# 説明


## 概要
<table>
	<tbody>
		<tr>
			<th>バージョン</th>
			<td>Laravel 8</td>
		</tr>
		<tr>
			<th>形式</th>
			<td>REST API</td>
		</tr>
		<tr>
			<th>認証ツール</th>
			<td>passport</td>
		</tr>
		<tr>
			<th>テストツール</th>
			<td>Postman</td>
		</tr>
		<tr>
			<th>Docs</th>
			<td>Scribe 2</td>
		</tr>
	</tbody>
</table>

#### AWSアクセス
__endpoint:__ http://18.177.202.240:8000/api

__docs:__ http://18.177.202.240:8000/docs

## APIについて

#### 使用中のAPI一覧
| Method    | URI                                     | Name                              | Action                                                                    | Middleware |
|-----------|-----------------------------------------|-----------------------------------|---------------------------------------------------------------------------|------------|
| GET|HEAD  | /                                       |                                   | Closure                                                                   | web        |
| GET|HEAD  | api/games                               | games.index                       | App\Http\Controllers\GameController@index                                 | api        |
|           |                                         |                                   |                                                                           | auth:api   |
| POST      | api/games                               | games.store                       | App\Http\Controllers\GameController@store                                 | api        |
|           |                                         |                                   |                                                                           | auth:api   |
| GET|HEAD  | api/games/{game}                        | games.show                        | App\Http\Controllers\GameController@show                                  | api        |
|           |                                         |                                   |                                                                           | auth:api   |
| PUT|PATCH | api/games/{game}                        | games.update                      | App\Http\Controllers\GameController@update                                | api        |
|           |                                         |                                   |                                                                           | auth:api   |
| DELETE    | api/games/{game}                        | games.destroy                     | App\Http\Controllers\GameController@destroy                               | api        |
|           |                                         |                                   |                                                                           | auth:api   |
| GET|HEAD  | api/games/{id}                          |                                   | App\Http\Controllers\GameController@show                                  | api        |
| POST      | api/login                               |                                   | App\Http\Controllers\AuthController@login                                 | api        |
| POST      | api/logout                              |                                   | Closure                                                                   | api        |
|           |                                         |                                   |                                                                           | auth:api   |
| POST      | api/signup                              |                                   | App\Http\Controllers\AuthController@signup                                | api        |
| GET|HEAD  | api/user                                |                                   | Closure                                                                   | api        |
|           |                                         |                                   |                                                                           | auth:api   |

#### ※注意

Middleware は ```auth:api``` である場合、Authorization は ```Bearer Auth``` に token の設定が必要です。

HEADER設定

```
Accept: application/json
```

返信はOKの場合、一部共通の内容は下記通りです。
```
{
    "success": true,
    "data": ...,
    "msg": ""
}
```
実用例には```data```の中身だけを記入します。

#### 認証の実用例
__登録：__ api/signup
送信：
```
{
    "username": "lorem_ipsum",
    "email": "lorem@ipsum.com",
    "password": "******",
    "r_password": "******"
}
```
返信：201 Created, 共通内容と違う
```
{
    "name": "lorem_ipsum",
    "email": "lorem@ipsum.com",
    "updated_at": "2021-03-05T00:30:27.000000Z",
    "created_at": "2021-03-05T00:30:27.000000Z",
    "id": 3
}
```

__ログイン：__ api/login
送信：
```
{
    "email": "example@email.com",
    "password": "******"
}
```
返信：
```
{
    "token": "...",
    "username": "hanabinoir"
}
```

__ログアウト：__ api/logout
送信：token 以外は必要なし
返信：200 OK で内容はなし

#### CRUD
__全表示：__ games.index
送信：api/games
返信：
```
[
    ...,
    {
        "asin": "B07L2YXZZM",
        "title": "戦国無双4",
        "price": 24.51,
        "created_at": "2021-03-05T00:43:23.000000Z",
        "updated_at": "2021-03-05T00:52:56.000000Z"
    },
    ...
]
```

__表示：__ games.show
送信：api/games/B08NJXN756
返信：
```
{
    "asin": B08NJXN756,
    "title": "仁王2 Complete Edition",
    "price": 52.18,
    "created_at": "2021-03-05T00:38:38.000000Z",
    "updated_at": "2021-03-05T00:38:38.000000Z"
}
```

__追加：__ games.store
送信：
```
{
    "asin": "B08NJXN756",
    "title": "仁王2 Complete Edition",
    "price": 52.18
}
```
返信：
```
{
    "asin": B08NJXN756,
    "title": "仁王2 Complete Edition",
    "price": 52.18,
    "updated_at": "2021-03-05T00:38:38.000000Z",
    "created_at": "2021-03-05T00:38:38.000000Z"
}
```

__更新：__ games.update
送信：api/games/B07L2YXZZM
```
{
    "title": "戦国無双4",
    "price": 24.51
}
```
返信：
```
{
    "asin": "B07L2YXZZM",
    "title": "戦国無双4",
    "price": 24.51,
    "created_at": "2021-03-05T00:43:23.000000Z",
    "updated_at": "2021-03-05T00:52:56.000000Z"
}
```

__削除：__ games.destroy
送信：api/games/B123456789
返信：
```
"Game deleted: B123456789."
```
