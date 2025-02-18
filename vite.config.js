import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

import fs from "fs";
import path from "path";

// NOTE: src https://github.com/eugene676/Laravel/blob/00d8ddcba0214f0ae09a948ccf0aeef888ed5eb6/vite.config.js

// recurively grab files
const getFiles = (dir, ext, fileList = []) => {
    const files = fs.readdirSync(dir);
    files.forEach((file) => {
        const filePath = path.join(dir, file);
        if (fs.statSync(filePath).isDirectory()) {
            getFiles(filePath, ext, fileList);
        } else if (path.extname(file) === ext) {
            fileList.push(filePath);
        }
    });
    return fileList;
};

const cssFiles = getFiles("resources/css", ".css");
const jsFiles = getFiles("resources/js", ".js");

export default defineConfig({
    plugins: [
        laravel({
            publicDirectory: "public",
            input: [...cssFiles, ...jsFiles], // Include from spread arrays
            // detectTls: "https://ssl-domain.com",
        }),
    ],
    //base: "https://ssl-domain.com/public",
});
