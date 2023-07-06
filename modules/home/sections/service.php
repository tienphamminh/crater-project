<!-- Services -->
<?php
$services = getAllRows("SELECT * FROM services ORDER BY name");
$homeService = json_decode(getOption('home_service'), true);
if (!empty($homeService['general'])) {
    $serviceGeneralOpts = json_decode($homeService['general'], true);
}
?>
<section id="services" class="services section">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeInUp">
                <div class="section-title">
                        <span class="title-bg"><?php echo (!empty($serviceGeneralOpts['bg_title']))
                                ? $serviceGeneralOpts['bg_title'] : null; ?></span>

                    <?php echo (!empty($serviceGeneralOpts['main_title']))
                        ? html_entity_decode($serviceGeneralOpts['main_title']) : null; ?>
                </div>
            </div>
        </div>
        <?php
        if (!empty($services)) :
            $temp = $services;
            while (count($services) <= 4) {
                $services = array_merge($services, $temp);
            }
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="service-slider">
                        <?php foreach ($services as $service) : ?>
                            <!-- Single Service -->
                            <div class="single-service">
                                <?php echo html_entity_decode($service['icon']); ?>
                                <h2><a href="#"><?php echo $service['name']; ?></a></h2>
                                <p>
                                    <?php echo $service['description']; ?>
                                </p>
                            </div>
                            <!-- End Single Service -->
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<!--/ End Services -->