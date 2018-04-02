<!doctype html>
<html lang="<?php echo $lang->getLocale(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $config['domain']; ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <div class="container h-100">
        <div class="row h-100 py-4 align-items-center justify-content-center">
            <div class="col-md-6 m-auto">
                <ul class="nav bg-light rounded mb-3 justify-content-end">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe"></i>
                            <?php echo $lang->getLocaleNative($lang->getLocale()); ?>
                        </a>
                        <div class="dropdown-menu">
                            <?php foreach ($lang->getAllLocales() as $locale) : ?>
                                <a href="<?php echo $lang->buildQueryString($locale); ?>" class="dropdown-item <?php echo ($locale == $lang->getLocale()) ? 'active': ''; ?>">
                                    <?php echo $lang->getLocaleNative($locale); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                </ul><!-- /.nav -->

                <div class="card mb-3">
                    <div class="card-body">

                        <h4 class="card-title"><?php echo $lang->translate('Enter your email address'); ?></h4>

                        <p class="card-text text-muted">
                            <?php echo $lang->translate('Enter your email address and receive a configuration profile to configure your email on your device.'); ?>
                        </p>

                        <form action="" method="POST">
                            <div class="form-row">
                                <div class="col-sm-6 col-md-7 col-xl-9 mb-2">
                                    <label for="email" class="sr-only"><?php echo $lang->translate('Email address'); ?></label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo $lang->translate('Email address'); ?>" required>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xl-3 mb-2">
                                    <button type="submit" name="submit" class="btn btn-primary mb-2 btn-block"><?php echo $lang->translate('Submit'); ?></button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div><!-- /.card -->

                <p class="text-center text-muted small">
                    &copy; <?php echo date('Y'); ?> <a href="<?php echo strip_tags($config['company_url']); ?>" target="_blank"><?php echo strip_tags($config['company_name']); ?></a>. <?php echo $lang->translate('All rights reserved.'); ?>
                </p>
            </div>
        </div>
    </div>


    <script src="/assets/js/app.js"></script>
</body>
</html>