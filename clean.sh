echo "$(tput setaf 6)" &&

echo 'Cleanup and bundling Process started...      (10%)\r' &&
npm run prod

echo -ne 'Removing existing "master-addons" built Folder......              (20%)\r'

rm -rf built
#mkdir built
mkdir -p built/adminify #multiple folder creation

echo -ne 'Adminify Cleanup and bundling files started......              (30%)\r'

rsync -r --exclude '.git' --exclude '.svn' --exclude 'built' --exclude 'node_modules' --exclude 'dev' --exclude '.vscode' . built/adminify/

echo -ne '..........          (50%)\r'

rm -rf built/adminify/assets/scss &&
rm -rf built/adminify/mix-manifest.json &&
rm -rf built/adminify/package.json &&
rm -rf built/adminify/package-lock.json &&
rm -rf built/adminify/webpack.mix.js &&
rm -rf built/adminify/.babelrc &&
rm -rf built/adminify/.gitignore &&
#rm -rf built/adminify/.DS_Store &&
find . -type f -name '*.DS_Store' -ls -delete &&
rm -rf built/adminify/.AppleDouble &&
rm -rf built/adminify/.LSOverride &&
rm -rf built/adminify/.Trashes &&
rm -rf built/adminify/.AppleDB &&
rm -rf built/adminify/.idea &&
rm -rf built/adminify/clean.sh &&
rm -rf built/adminify/yarn.lock &&
rm -rf built/adminify/composer.json &&
rm -rf built/adminify/composer.lock &&
rm -rf built/adminify/assets/nothing.js &&
rm -rf built/adminify/vendor/composer/LICENSE &&
rm -rf built/adminify/vendor/composer/installed.json &&
rm -rf built/adminify/vendor/composer/bin &&

# Remove all Sourcemap(.map) files
find . -type f -name '*.map' -ls -delete &&
find . -type f -name '*.LICENSE.txt' -ls -delete &&

echo -ne 'Creating adminify.zip file ......(70%)'

cd built
zip -r adminify.zip adminify/.
rm -r adminify #Delete adminify folder

echo -ne 'Congratulations... Successfully done ..........(100%)'

echo "$(tput setaf 2)" &&
echo "Clean process completed!"
echo "$(tput sgr0)"


cd ../
npm run development
