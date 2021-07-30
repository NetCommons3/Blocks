Blocks
==============

[![Tests Status](https://github.com/NetCommons3/Blocks/actions/workflows/tests.yml/badge.svg?branch=master)](https://github.com/NetCommons3/Blocks/actions/workflows/tests.yml)
[![Coverage Status](https://coveralls.io/repos/NetCommons3/Blocks/badge.svg?branch=master)](https://coveralls.io/r/NetCommons3/Blocks?branch=master)
[![Stable Version](https://img.shields.io/packagist/v/netcommons/blocks.svg?label=stable)](https://packagist.org/packages/netcommons/blocks)

NetCommonsのブロックとは、フレームに割り当てるデータ概念です。<br>
フレームに配置されるプラグインは、１つ以上のブロックを持ち１ブロックにたいして、複数のコンテンツが関連付けられます。<br>

フレームの右上部Glyphicon(歯車)をクリックすると表示されるブロック設定画面の共通処理をまとめています。


### BlockTabsComponent
なくなる予定<br>
BlockFormHelperに統合

### [BlockBehavior](https://github.com/NetCommons3/NetCommons3Docs/blob/master/phpdocMd/Blocks/BlockBehavior.md#blockbehavior)

### [BlockRolePermissionBehavior](https://github.com/NetCommons3/NetCommons3Docs/blob/master/phpdocMd/Blocks/BlockRolePermissionBehavior.md#blockrolepermissionbehavior)

### BlockTabsHelper
ブロック設定画面の、ブロック設定タブ、および、権限設定タブを作成します。

### BlockRolePermissionFormHelper
ブロック設定画面の権限チェックボックスを描画します。
BlockFormHelperと一緒で良い気がする。

### BlockFormHelper
ブロック一覧のフレーム配置ラジオボタンを描画します。

