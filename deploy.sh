vendor/bin/jigsaw build production
npm run production
rsync -v -rz --checksum --delete build_production/ web:/var/www/basecodefieldguide.com/public/podcast
rm -rf build_production
