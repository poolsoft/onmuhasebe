<?php
$yi = 0;
$yxi = 0;
$yp = $api::yorumpuanilanid($ilan->id);
if ($cls->urunsecenekvarmi($ilan->id)) {
    $ssecenek = $cls->urunsecenekust($ilan->id);

    $uts = $cls->urun_tum_secenek($ilan->id); ?>
    <script>

        var resim;
        var secenekvarmi = 1;
        var sss = JSON.parse('<?php echo json_encode($uts); ?>');
        var idstok = 1;
        var scnkid;
    </script>

<?php } else { ?>
    <script>
        var secenekvarmi = 2;
    </script>

    <?php $ssecenek = "";
}


foreach ($yp as $ilanyorum) {
    $yi++;
    if ($ilanyorum->puan) {
        $yxi++;
        $puan += $ilanyorum->puan;
    }
}
$puan = ceil($puan / $yxi);

// ziyaretçi sayısı alma

if ($ilan->onay == 1 && $ilan->aktif == 1):
    $api::sayacekle($ilan->id, $ilan->b_tarih);
endif;
?>
<section>
    <div class="second-page-container">
        <div class="container">
            <div class="row">

                <div class="col-md-9">
                    <div class="block-breadcrumb">
                        <ul class="breadcrumb">
                            <li><a href="<?php SELF::go(""); ?>"
                                   class="breadcrump-link"><?php echo $lang->anasayfa; ?></a></li>
                            <?php
                            $ki = 0;
                            foreach ($cls->kategori_in($ilan->kategori) as $k) {
                                $ktgid[] = $k->id;
                                $ki++;
                                ?>
                                <li>
                                    <a href="<?php self::go('index/kategoriler/id/' . $k->id . '/name/' . $this->help("seourl")->seo($k->kategori_adi)); ?>"
                                       class="breadcrump-link">
                                        <?php echo $k->kategori_adi; ?> </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>


                    <?php $rsm = $api::resim($ilan->id);
                    foreach ($rsm as $xxxx) {
                        $resim[] = str_replace('_', '/', $xxxx->resim);
                    }
                    ?>
                    <div class="block-product-detail">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="product-image">
                                    <img id="product-zoom" src='<?php echo $this->thumbresim($resim[0]); ?>'
                                         data-zoom-image="<?php echo $resim[0]; ?>" alt="">
                                    <div id="gal1">
                                        <?php foreach ($resim as $image) { ?>
                                            <a href="javascript:;" data-image="<?php echo $this->thumbresim($image); ?>"
                                               data-zoom-image="<?php echo str_replace('_', '/', $image); ?>">
                                                <img class="thmimg" id="img_01"
                                                     src="<?php echo $this->thumbresim($image); ?>" alt="">
                                            </a>

                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">


                                <div class="product-detail-section">
                                    <h3> <?php echo $ilan->baslik; ?></h3>


                                    <div class="product-information">


                                        <div class="product-rating">
                                            <label class="pull-left">Puan:</label>
                                            <div class="stars">
                                                <?php echo $this->help("uhyildiz")->yildiz($puan); ?>
                                            </div>
                                            <a class="reviews_button" href="javascript:void(0)"
                                               onclick="$('a[href=\'#review\']').trigger('click'); $('html, body').animate({scrollTop: $('#review').offset().top}, 1000);return false;"><?php echo $yi; ?>
                                                Yorum</a> | <a class="write_review_button" href="javascript:void(0)"
                                                               onclick="yorumyaz();">Yorum yaz</a>

                                        </div>
                                        <?php $cpn = $api::saticiadi($ilan->user_id);
                                        if ($cpn) { ?>
                                            <div class="clearfix" style="-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
    background-color: #f7f7f7;">
                                                <label class="pull-left"> Satıcı </label>
                                                <p class="description">
                                                    <?php echo $api::saticiadi($ilan->user_id); ?>
                                                </p>

                                            </div>
                                        <?php } ?>

                                        <?php foreach ($cls->ilan_secenek($ilan->secenek) as $secenek): if ($secenek['baslik']): ?>

                                            <div class="clearfix">
                                                <label class="pull-left">  <?php echo $secenek['baslik']; ?>:</label>
                                                <p class="description"><?php echo $secenek['sonuc']; ?></p>
                                            </div>
                                        <?php endif; endforeach; ?>

                                        <div class="clearfix">
                                            <label class="pull-left">Fiyat:</label>


                                            <?php $trh = date("Y-m-d", strtotime("-1 week"));
                                            if ($ilan->firsat == 1 && $ilan->fft >= $trh) : ?>
                                                <p class="product-price">
                                                    <span><?php echo number_format($ilan->fiyat, 2, ",", "."); ?> </span>
                                                    <?php $gercekfiyat = $ilan->ff;
                                                    echo number_format($ilan->ff, 2, ",", ".") . $ilan->kur; ?>
                                                </p>


                                            <?php else: ?>
                                                <p><?php $gercekfiyat = $ilan->fiyat;
                                                    echo number_format($ilan->fiyat, 2, ",", "."); ?><?php echo $ilan->kur; ?> </p>
                                            <?php endif; ?>

                                        </div>


                                        <?php if ($ssecenek):
                                            foreach ($ssecenek as $secenekx):

                                                ?>
                                                <div class="clearfix">
                                                    <label class="pull-left">  <?php echo $cls->modul_items_sa($secenekx->secenek); ?>
                                                        :</label>


                                                    <p class="description">
                                                        <select onchange="xxx(this.value)" class="form-control"
                                                                name="secnk" id="secnk">
                                                            <option value=''>Seçiniz</option>
                                                            <?php foreach ($cls->urunsecenekalt($ilan->id, $secenekx->secenek) as $seceneky): ?>

                                                                <option value='<?php echo $seceneky->id; ?>'><?php echo $cls->secenekler_sa($seceneky->deger); ?></option>

                                                            <?php endforeach; ?>
                                                        </select></p>
                                                </div>
                                            <?php endforeach; endif; ?>


                                        <div class="clearfix">
                                            <label class="pull-left">Toplam:</label>
                                            <p class="product-price"
                                               id='toplamfiyat'><?php echo number_format($gercekfiyat, 2, ",", "."); ?><?php echo $ilan->kur; ?> </p>
                                        </div>
                                        <script>
                                            var urunadet = 1;
                                            var fiyatx = <?php echo $gercekfiyat; ?>;
                                            var fiyat = <?php echo $gercekfiyat; ?>;


                                            function trmoneyformat(price, tl) {

                                                if (tl == "TL") {
                                                    var currency_symbol = "₺"

                                                    var formattedOutput = new Intl.NumberFormat('tr-TR', {
                                                        style: 'currency',
                                                        currency: 'TRY',
                                                        minimumFractionDigits: 2,
                                                    });
                                                }
                                                if (tl == "USD") {
                                                    var currency_symbol = "$"
                                                    const formatter = new Intl.NumberFormat('en-US', {
                                                        style: 'currency',
                                                        currency: 'USD',
                                                        minimumFractionDigits: 2
                                                    })
                                                }
                                                if (tl == "EURO") {

                                                    var currency_symbol = "€"
                                                    const formatter = new Intl.NumberFormat('it-IT', {
                                                        style: 'currency',
                                                        currency: 'EUR',
                                                        minimumFractionDigits: 2
                                                    })

                                                }
                                                if (tl == "GBP") {
                                                    var currency_symbol = "£"
                                                    const formatter = new Intl.NumberFormat('en-GB', {
                                                        style: 'currency',
                                                        currency: 'GBP',
                                                        minimumFractionDigits: 2
                                                    })
                                                }

                                                console.log(formattedOutput.format(price).replace(currency_symbol, ''));
                                                return formattedOutput.format(price).replace(currency_symbol, '');
                                            }

                                            function total(adet) {
                                                urunadet = adet;
                                                var toplam = Math.round(fiyat * adet);
                                                document.getElementById("toplamfiyat").innerHTML = trmoneyformat(toplam, "<?php echo $ilan->kur; ?>") + " <?php echo $ilan->kur; ?>";

                                            }
                                        </script>
                                        <div class="clearfix">
                                            <label class="pull-left" style=" margin-top: 8px">
                                                <select style="width: 90px;" onchange="total(this.value)"
                                                        class="form-control" name="quantity" id="quantitySelect">
                                                    <?php if ($ilan->stok >= 1): for ($i = 0; $i < $ilan->stok; $i++): ?>
                                                        <option><?php echo $i + 1; ?></option><?php endfor; else: ?>
                                                        <option>1</option><?php endif; ?>
                                                </select></label>
                                            <div class="shopping-cart-buttons pull-left">

                                                <?php if ($ilan->gav == 1) : ?>

                                                    <a href="javascript:void(0)" class="shoping"
                                                       onclick="cartid.add('');"><i class="fa fa-shopping-cart"></i>
                                                        Sepete Ekle</a> <?php endif; ?>
                                                <a href="javascript:void(0)" title="Favoriler"
                                                   onclick="wishlistid.add('');"><i class="fa fa-heart-o"></i></a>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-border block-form">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills  nav-justified">
                            <li class="active"><a href="#description" data-toggle="tab">AÇIKLAMA</a></li>
                            <li><a href="#review" data-toggle="tab">YORUM</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div style="overflow: overlay;" class="tab-pane active" id="description">
                                <br>
                                <h3>Ürün Bilgisi</h3>
                                <hr>

                                <?php echo html_entity_decode($ilan->aciklama); ?>
                            </div>

                            <div class="tab-pane" id="review">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Müşteri Yorumları</h3>
                                        <hr>
                                        <?php if ($yp) {
                                            foreach ($yp as $ilanyorum) {


                                                $yazan = $api::useridtoname($ilanyorum->userid); ?>

                                                <div class="review-header">
                                                    <h5><?php echo $yazan->name . ' ' . $yazan->surname; ?></h5>
                                                    <div class="product-rating">
                                                        <div class="stars">
                                                            <?php echo $this->help("uhyildiz")->yildiz($ilanyorum->puan); ?>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted"><?php echo $ilanyorum->tarih; ?></small>
                                                </div>
                                                <div class="review-body">
                                                    <p><?php echo $ilanyorum->yorum; ?></p>

                                                </div>
                                                <hr>

                                                <?php

                                            }
                                        } else {
                                            echo '<div id="review"><p>Yorum Yapılmamış.</p></div> ';
                                        }
                                        ?>


                                        <hr>
                                    </div>
                                </div>
                                <form id="yorum" name="yorumalani">


                                    <h2 id="review-title">Yorum yap</h2>
                                    <div class="contacts-form">
                                        <div class="form-group">
                                            <span class="fa fa-user"></span>
                                            <label class="notranslate">
                                                <?php $ben = $api::useridtoname($this->session->get("user_id"));
                                                if ($ben) {
                                                    echo "$ben->name $ben->surname";
                                                } else {
                                                    echo "Login olmalısın";
                                                } ?>
                                            </label>

                                            <input type="hidden" name="ilanid" value="<?php echo $this->val->id; ?>"/>
                                            <input type="hidden" name="ilanuserid"
                                                   value="<?php echo $ilan->user_id; ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <span class="fa fa-comment"></span>
                                            <textarea id="mesajtext" class="form-control" name="text"
                                                      onblur="if (this.value == '') {this.value = 'Your Review';}"
                                                      onfocus="if(this.value == 'Your Review') {this.value = '';}">Your Review</textarea>
                                        </div>
                                        <span style="font-size: 11px;"><span class="text-danger">Not:</span> HTML Kullanmayınız!</span>
                                        <br>
                                        <style>

                                            .star-rating {
                                                cursor: pointer;
                                                font-size: 0;
                                                white-space: nowrap;
                                                display: inline-block;
                                                width: 250px;
                                                height: 50px;
                                                overflow: hidden;
                                                position: relative;
                                                background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjREREREREIiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
                                                background-size: contain;
                                            }

                                            .star-rating i {
                                                cursor: pointer;
                                                opacity: 0;
                                                position: absolute;
                                                left: 0;
                                                top: 0;
                                                height: 100%;
                                                width: 20%;
                                                z-index: 1;
                                                background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjRkZERjg4IiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
                                                background-size: contain;
                                            }

                                            .star-rating input {
                                                cursor: pointer;
                                                -moz-appearance: none;
                                                -webkit-appearance: none;
                                                opacity: 0;
                                                display: inline-block;
                                                width: 20%;
                                                height: 100%;
                                                margin: 0;
                                                padding: 0;
                                                z-index: 2;
                                                position: relative;
                                            }

                                            .star-rating input:hover + i,
                                            .star-rating input:checked + i {
                                                opacity: 1;
                                            }

                                            .star-rating i ~ i {
                                                width: 40%;
                                            }

                                            .star-rating i ~ i ~ i {
                                                width: 60%;
                                            }

                                            .star-rating i ~ i ~ i ~ i {
                                                width: 80%;
                                            }

                                            .star-rating i ~ i ~ i ~ i ~ i {
                                                width: 100%;
                                            }

                                            ::after,
                                            ::before {
                                                height: 100%;
                                                padding: 0;
                                                margin: 0;
                                                box-sizing: border-box;
                                                text-align: center;
                                                vertical-align: middle;
                                            }

                                        </style>
                                        <br>

                                        <span class="star-rating">
  <input type="radio" name="rating" value="1"><i></i>
  <input type="radio" name="rating" value="2"><i></i>
  <input type="radio" name="rating" value="3"><i></i>
  <input type="radio" name="rating" value="4"><i></i>
  <input type="radio" name="rating" value="5"><i></i>
</span>
                                        <br>

                                        <!--<div class="form-group">
<div class="col-sm-12">
<div class="g-recaptcha" data-sitekey="<b>Notice</b>: Undefined variable: site_key in <b>/home/wwwesecuritybaza/public_html/catalog/view/theme/so-shoppystore/template/product/product.tpl</b> on line <b>930</b>"></div>
</div>
</div> -->
                                        <?php if ($ben) { ?>
                                            <div id="yrmbtn" class="buttons clearfix"><a id="button-review"
                                                                                         class="btn btn-mega"
                                                                                         onclick="yorumla()">Kaydet</a>
                                            </div>
                                        <?php } else {
                                            echo "Login olmalısın";
                                        } ?>
                                        <span id="yorumcevap" style=" color: red"></span>
                                    </div>
                                </form>

                            </div>

                        </div>


                    </div>


                </div>
                <div class="col-md-3">

                    <div class="main-category-block ">

                        <div class="main-category-title">
                            <i class="fa fa-list"></i> kategoriler

                        </div>
                    </div>
                    <div class="widget-block">

                        <?php foreach ($cls->katgustid($ktgid[$kid - 1]) as $ktg) {
                            ?>

                            <ul class="list-unstyled ul-side-category">

                                <li><a href=""><i
                                                class="<?php echo $ktg->ikon; ?>"></i><?php echo $ktg->kategori_adi; ?>
                                    </a>
                                    <ul class="sub-category">
                                        <?php foreach ($cls->katgustid($ktg->id) as $value) { ?>
                                            <li>
                                                <a href="<?php self::go('index/kategoriler/id/' . $value->id . '/name/' . $this->help("seourl")->seo($value->kategori_adi)); ?>"><?php echo $value->kategori_adi; ?>
                                                    <!--?php echo $api::ilanadet($value->id); ?--></span></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </ul>
                        <?php } ?>


                    </div>
                    <?php $tekfirsat = $api::firsatnewtek();
                    if ($tekfirsat) { ?>

                        <article class="product light last-sale">
                            <figure class="figure-hover-overlay">
                                <a href="<?php SELF::go('ilan/detay/id/' . $tekfirsat->id . '/' . $this->help("seourl")->seo($tekfirsat->baslik)); ?>"
                                   class="figure-href"></a>
                                <?php if ($tekfirsat->firsat == 1 && $tekfirsat->fft >= $trh): ?>
                                    <div class="product-sale">
                                        <?php echo $this->indirim($tekfirsat->ff, $tekfirsat->fiyat); ?>% <br>
                                    </div>
                                <?php endif; ?>
                                <div class="product-sale-time"><p class="time"></p></div>
                                <a href="javascript:void(0)" title="Favoriler"
                                   onclick="wishlist.add('<?php echo $tekfirsat->id; ?>','<?php echo $api::thumbresim($tekfirsat->id); ?>','<?php echo $tekfirsat->baslik; ?>');"
                                   class="product-wishlist"><i class="fa fa-heart-o"></i></a>
                                <img class="img-overlay img-responsive"
                                     src="<?php echo $api::thumbresim($tekfirsat->id); ?>" alt="" title="">
                                <?php if ($api::thumbresim2($tekfirsat->id)):
                                    $resimf = $api::thumbresim2($tekfirsat->id);
                                    ?>
                                    <img src="<?php echo $resimf; ?>" class="img-responsive" alt="">
                                <?php else:

                                    $resimf = $api::thumbresim($tekfirsat->id);
                                    ?>
                                    <img src="<?php echo $resimf; ?>" class="img-responsive" alt="">
                                <?php endif; ?>                                        </figure>
                            <div class="product-caption">
                                <div class="block-name">
                                    <a href="<?php SELF::go('ilan/detay/id/' . $tekfirsat->id . '/' . $this->help("seourl")->seo($tekfirsat->baslik)); ?>"
                                       class="product-name"><?php echo $tekfirsat->baslik; ?></a>
                                    <?php if ($tekfirsat->firsat == 1 && $tekfirsat->fft >= $trh) : ?>
                                        <p class="product-price">
                                            <span><?php echo number_format($tekfirsat->fiyat, 2, ",", "."); ?> </span>

                                        </p>  <?php echo number_format($tekfirsat->ff, 2, ",", ".") . $tekfirsat->kur; ?>


                                    <?php else: ?>
                                        <p><?php echo number_format($tekfirsat->fiyat, 2, ",", "."); ?><?php echo $tekfirsat->kur; ?> </p>
                                    <?php endif; ?>


                                </div>
                                <?php if ($tekfirsat->gav && $cls->urunsecenekvarmi($tekfirsat->id)): ?>
                                <div class="product-cart">
                                    <a href="javascript:void(0)" class="shoping"
                                       onclick="cartadd('<?php echo $tekfirsat->id; ?>','<?php echo $resimf; ?>');"><i
                                                class="fa fa-shopping-cart"></i> </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </article>


                        <script>
                            $(function () {

                                <?php
                                $timestamp = strtotime(date("Y-m-d", strtotime($tekfirsat->fft)) . " +1 week");
                                $time = date("M j, Y 23:59:59", $timestamp);
                                ?>



                                $(".time").countdown({
                                    date: '<?php echo $time; ?>',
                                    yearsAndMonths: true,
                                    leadingZero: true
                                });
                            });
                        </script>

                    <?php } ?>


                </div>

            </div>
        </div>
    </div>

</section>
<script>


    function yorumyaz() {

        $('a[href=\'#review\']').trigger('click');
        $('#mesajtext').focus();
        return false;
    }

    function yorumla() {
        if ($('#mesajtext').val() == "Your Review") {
            alert("you should write a comment");
            return false;
        } else {


            $.ajax({
                type: 'POST',
                url: '<?php SELF::go("user_ajax/yorumekle"); ?>',
                data: $('#yorum').serialize(),
                success: function (cevap) {
                    if (cevap == 1) {
                        $('#yorumcevap').html('Yorumunuz başarılı şekilde gönderilmiştir. Onaylandıktan sonra yayınlanacaktır.');
                        $('#yrmbtn').hide();
                    } else {
                        $('#yorumcevap').html('Bir sorun ile karşılaşıldı.');
                    }
                }
            });
        }
    }


    function yukle(url, css) {
        $.post(url).done(function (sonuc) {
            $("." + css).html(sonuc);
        });
    }

    function favekleid() {
        var url = "<?php SELF::go('user/favekle/ilan_id/' . $ilan->id); ?>";
        $.post(url).done(function (sonuc) {
            if (sonuc == 1) {
                addProductNotice('<?php echo $ilan->baslik; ?>', '<img src="<?php echo $resim[0]; ?>" alt="">', '<h3>  added to Favorite</h3>', 'success');
            } else if (sonuc == 2) {
                addProductNotice('<?php echo $ilan->baslik; ?>', '<img src="<?php echo $resim[0]; ?>" alt="">', '<h3>  Added before</h3>', 'error');
            } else if (sonuc == 3) {
                addProductNotice('<?php echo $ilan->baslik; ?>', '<img src="<?php echo $resim[0]; ?>" alt="">', '<h3><a href="<?php SELF::go('user/login');?>"><i class="fa fa-pencil-square-o"></i> Login</a> or <a href="<?php SELF::go('user/kayit');?>"><i class="fa fa-user"></i> Register</a></h3>', 'error');
            }
        });
    }


    function sepetupdateid() {
        $.post("<?php SELF::go('index/sepetreplace'); ?>", function (data) {
            $("#headcartref").html(data);
        });
    }

    function xxx(id) {
        scnkid = id;
        fiyat = Number(sss[id].fiyat) + Number(fiyatx);
        resim = sss[id].resim;
        if (resim) {
            var thmp = resim.replace('big', 'thumb');
            $("#product-zoom").attr("src", thmp).attr("data-zoom-image", resim);
            $(".zoomWindow").css('background-image', 'url(' + resim + ')');

        }

        var i;
        urunadet = 0;
        $('#quantitySelect').empty();
        $("#quantitySelect").append("<option value='0'>Seçiniz</option>");
        for (i = 1; i <= sss[id].stok; i++) {
            $("#quantitySelect").append("<option>" + i + "</option>");
        }

        var toplam = Math.round(fiyat * urunadet);
        document.getElementById("toplamfiyat").innerHTML = trmoneyformat(toplam, "<?php echo $ilan->kur; ?>") + " <?php echo $ilan->kur; ?>";

    }

    function sepeteekleid() {
        if (urunadet) {
            if (secenekvarmi == 2) {

                var myKeyVals = {
                    uid: '<?php echo $ilan->id; ?>',
                    adet: urunadet,
                    resim: '<?php echo $resim[0]; ?>',
                    baslik: '<?php echo $ilan->baslik; ?>',
                    fiyat: '<?php echo $ilan->fiyat; ?>',
                    kur: '<?php echo $ilan->kur; ?>'
                };
                var rsm = '<?php echo $resim[0]; ?>';
            } else {

                if (scnkid) {

                    var myKeyVals = {
                        uid: '<?php echo $ilan->id; ?>',
                        adet: urunadet,
                        resim: resim,
                        baslik: '<?php echo $ilan->baslik; ?>',
                        fiyat: fiyat,
                        kur: '<?php echo $ilan->kur; ?>',
                        snkid: scnkid
                    };
                    var rsm = resim;

                } else {
                    $("#secnk").focus();
                    return false;
                }

            }
            var url = "<?php SELF::go('index/sepetekle'); ?>";
            $.post(url, myKeyVals)
                .done(function (sonuc) {

                    if (sonuc == 1) {
                        addProductNotice('<?php echo $ilan->baslik; ?>', '<img src="' + rsm + '" alt="">', '<h3>Ürün sepete eklendi</h3>', 'success');

                        sepetupdateid();

                    } else if (sonuc == 2) {
                        addProductNotice('<?php echo $ilan->baslik; ?>', '<img src="' + rsm + '" alt="">', '<h3>Yeterli ürün ürün stoğu bulunmamaktadır</h3>', 'error');
                    } else if (sonuc == 3) {
                        addProductNotice('<?php echo $ilan->baslik; ?>', '<img src="' + rsm + '" alt="">', '<h3><a href="<?php SELF::go('user/login');?>"><i class="fa fa-pencil-square-o"></i> Login</a> or <a href="<?php SELF::go('user/kayit');?>"><i class="fa fa-user"></i> Register</a></h3>', 'error');
                    }
                });
        } else {
            $("#quantitySelect").focus();
        }
    }


    var cartid = {
        'add': function () {
            sepeteekleid();
        }
    }
    var wishlistid = {
        'add': function (product_id) {
            favekleid();
        }
    }

    function addProductNotice(title, thumb, text, type) {
        $.jGrowl.defaults.closer = false;
        //Stop jGrowl
        //$.jGrowl.defaults.sticky = true;
        var tpl = thumb + '<h3>' + text + '</h3>';
        $.jGrowl(tpl, {
            life: 4000,
            header: title,
            speed: 'slow',
            theme: type
        });
    }


</script>
