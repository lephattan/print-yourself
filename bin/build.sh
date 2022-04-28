#!/bin/sh 

PLGUIN_SLUG="print-yourself"
PROJECT_PATH=$(pwd)
BUILD_PATH="${PROJECT_PATH}/build"
DEST_PATH="$BUILD_PATH/$PLGUIN_SLUG"

echo "Generating build directory..."
rm -rf "$BUILD_PATH"
mkdir -p "$DEST_PATH"

echo "Syncing files..."
rsync -rc --exclude-from="$PROJECT_PATH/.distignore" "$PROJECT_PATH/" "$DEST_PATH/" --delete --delete-excluded

echo "Generating zip file..."
cd "$BUILD_PATH" || exit
zip -q -r "${PLGUIN_SLUG}.zip" "$PLGUIN_SLUG/"

cd "$PROJECT_PATH" || exit
mv "$BUILD_PATH/${PLGUIN_SLUG}.zip" "$PROJECT_PATH"
echo "${PLGUIN_SLUG}.zip file generated!"

echo "Removing build directory"
rm -rf "$BUILD_PATH"

echo "Build done!"

