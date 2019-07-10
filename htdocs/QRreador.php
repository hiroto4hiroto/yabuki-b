<?php
session_start();
$list = "";
    //業者でなければ弾く
if (!isset($_SESSION['VENDER'])) {
    header('Location: login.php');
    exit;
}
    try {
        require_once 'database_conf.php';
        $db = new PDO($dsn, $dbUser, $dbPass);
        
        if( !empty($_POST['delivery']) ){
            //予約一覧作成
            //SQL作成・実行
            $sql = 'UPDATE `ordertable` LEFT JOIN bentotable ON `ordertable`.id = bentotable.id';
            $sql .= ' SET `ordertable`.check = 1 WHERE `ordertable`.user = "'. $_POST["user"] .'" and bentotable.date = "'. $getdate .'";';
            $prepare = $db->prepare($sql);
            $prepare->execute();
        }
        
        //予約一覧作成
        //SQL作成・実行
        $sql = "SELECT `order`.check as `check`, `bento`.date as `date`, `order`.user as `user`, `order`.id as `id`, `bento`.name as `name`";
        $sql .= " FROM `ordertable` as `order` LEFT JOIN `bentotable` as `bento` ON `order`.id = `bento`.id";
        $sql .= " ORDER BY `order`.check, `bento`.date, `order`.user, `order`.id;";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        
        $list .= '予約一覧';
        $list .= '<br><table style="width: 80vw; height: 2em;"><tr>';
        $list .= '<td style="width: 5vw;">受取';
        $list .= '<td style="width: 10vw;">日付';
        $list .= '<td style="width: 10vw;">学生番号';
        $list .= '<td style="width: 20vw;">弁当名';
        //$list .= '<td style="width: 35vw;">UUID';
        foreach ($prepare->fetchAll(PDO::FETCH_ASSOC) as $result)
        {
            $plusClass = '';
            if ($result["date"] == $getdate) $plusClass = ' class="todayOrder" ';
                
            $list .= '<tr>';
            if ($result["check"] == 1)
                $list .= '<td'. $plusClass .' style="color:blue;">完了';
            else $list .= '<td'. $plusClass .' style="color:red;">未了';
            $list .= '<td'. $plusClass .'>'. $result["date"];
            $list .= '<td'. $plusClass .'>'. $result["user"];
            $list .= '<td'. $plusClass .'>'. $result["name"];
        }
        $list .= '</table>';
    } catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <title>弁当事前予約サービス 引き渡し操作</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
        <script type="text/javascript" src="instascan.min.js"></script>
    </head>

    <body class="vender">
        <p>弁当事前予約サービス</p>
        <h1>引き渡し操作</h1>

        <div id="app">
            <div class="sidebar">
                <section class="cameras">
                    <h2>Cameras</h2>
                    <ul>
                        <li v-if="cameras.length === 0" class="empty">No cameras found</li>
                        <li v-for="camera in cameras">
                            <span v-if="camera.id == activeCameraId" :title="formatName(camera.name)" class="active">{{ formatName(camera.name) }}</span>
                            <span v-if="camera.id != activeCameraId" :title="formatName(camera.name)">
                                <a @click.stop="selectCamera(camera)">{{ formatName(camera.name) }}</a>
                            </span>
                        </li>
                    </ul>
                </section>
                <section class="scans">
                    <h2>Scans</h2>
                    <ul v-if="scans.length === 0">
                        <li class="empty">No scans yet</li>
                    </ul>
                    <transition-group name="scans" tag="ul">
                        <li v-for="scan in scans" :key="scan.date" :title="scan.content">{{ scan.content }}</li>
                    </transition-group>
                </section>
            </div>
            <div class="preview-container">
                <video id="preview"></video>
            </div>
        </div>

        <br>
        <?php echo $list; ?>

        <script>
            var app = new Vue({
                el: '#app',
                data: {
                    scanner: null,
                    activeCameraId: null,
                    cameras: [],
                    scans: []
                },
                mounted: function () {
                    var self = this;
                    self.scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5 });
                    self.scanner.addListener('scan', function (content, image) {
                        self.scans.unshift({ date: +(Date.now()), content: content });
                    });
                    Instascan.Camera.getCameras().then(function (cameras) {
                        self.cameras = cameras;
                        if (cameras.length > 0) {
                            self.activeCameraId = cameras[0].id;
                            self.scanner.start(cameras[0]);
                        } else {
                            console.error('No cameras found.');
                        }
                    }).catch(function (e) {
                        console.error(e);
                    });
                },
                methods: {
                    formatName: function (name) {
                        return name || '(unknown)';
                    },
                    selectCamera: function (camera) {
                        this.activeCameraId = camera.id;
                        this.scanner.start(camera);
                    }
                }
            });
        </script>
    </body>

    </html>
