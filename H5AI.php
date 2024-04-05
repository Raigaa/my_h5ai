<?php

class H5AI
{
    private array $_tree = [];
    private string $_path;

    private array $_navigationHistory = [];

    private array $_iconMappings = [
        'php' => 'file_php.png',
        'html' => 'file_html.png',
        'css' => 'file_css.png',
        'js' => 'file_js.png',
        'py' => 'file_py.png',
        'json' => 'file_json.png',
        'png' => 'file_png.png',
        'jpeg' => 'file_jpeg.png',
        'jpg' => 'file_jpg.png',
        'pdf' => 'file_pdf.png',
        'md' => 'file_md.png',
        'gif' => 'file_gif.png',
        'txt' => 'file_txt.png',
        'sh' => 'file_sh.png',
        'xml' => 'file_xml.png',
        'mp4' => 'file_mp4.png',
        'mp3' => 'file_mp3.png',
        'pub' => 'file_pub.png',
        'tmp' => 'file_tmp.png',
        'sql' => 'file_sql.png',
        'jsx' => 'file_jsx.png',
        'yml' => 'file_yml.png',
        'ts' => 'file_ts.png',
        'svg' => 'file_svg.png',
        'scss' => 'file_scss.png',
        'cpp' => 'file_cpp.png',
    ];

    public function __construct(string $path)
    {
        $this->_path = rtrim($path, '/') . '/';
        $this->generateTree();
    }

    public function getPath(): string
    {
        return $this->_path;
    }

    public function getTree(): array
    {
        return $this->_tree;
    }

    public function generateTree(): void
    {
        $this->_tree = $this->scanDirectory($this->_path);
    }

    public function render(): void
    {
        echo $this->generateDirectoryListingHTML();
    }

    private function generateDirectoryListingHTML(): string
    {
        $html = '<table>';
        $html .= '<tr><th>Icon</th><th>Title</th><th>Type</th><th>Size</th><th>Date</th></tr>';

        foreach ($this->_tree as $item) {
            $html .= '<tr>';
            if ($item['isDir']) {
                $html .= '<td><img src="icons/directory.png" alt="Folder Icon"></td>';
                $html .= '<td>' . $this->generateDirectoryLink($item['path'], $item['title']) . '</td>';
                $html .= '<td>Directory</td>';
                $html .= '<td>-</td>';
                $html .= '<td>' . $item['date'] . '</td>';
            } else {
                $html .= '<td><img src="icons/' . $this->getFileIcon($item['title']) . '" alt="File Icon"></td>';
                $html .= '<td>' . $this->generateFileLink($item['path'], $item['title']) . '</td>';
                $html .= '<td>File</td>';
                $html .= '<td>' . $this->formatSize($item['size']) . '</td>';
                $html .= '<td>' . $item['date'] . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table>';
        return $html;
    }

    private function formatSize($size): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;

        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }



    private function scanDirectory(string $directory): array
    {
        $files = [];
        $fileList = scandir($directory);
        foreach ($fileList as $file) {
            if (!preg_match('/^\..*$/', $file) && !is_link($directory . $file)) {
                $path = $directory . $file;
                $isDir = is_dir($path);
                $size = $isDir ? 0 : filesize($path);
                $date = date('Y-m-d H:i:s', filemtime($path));
                $files[] = [
                    'title' => $file,
                    'isDir' => $isDir,
                    'size' => $size,
                    'date' => $date,
                    'path' => $path
                ];
            }
        }
        return $files;
    }

    private function generateFileLink($path, $title): string
    {
        return '<a href="#" class="file-link" data-file="' . htmlspecialchars($path) . '">' . $title . '</a>';
    }

    private function getFileIcon($filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        return $this->_iconMappings[$extension] ?? 'default_file_icon.png';
    }

    private function generateDirectoryLink($path, $title): string
    {
        return '<a href="?path=' . $path . '">' . $title . '</a>';
    }

    public function showContent(string $file): string
    {
        if (file_exists($file)) {
            return $this->getContent($file);
        } else {
            return 'File not found';
        }
    }

    public function getContent(string $file): string
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $videoExtensions = ['mp4'];
        $audioExtensions = ['mp3'];
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if (!file_exists($file) || !is_readable($file)) {
            return 'Fichier non trouvé ou non lisible';
        }

        if (in_array(strtolower($extension), $imageExtensions) && is_file($file)) {
            $data = base64_encode(file_get_contents($file));
            return '<img id="imgFile" src="data:image/' . $extension . ';base64,' . $data . '">';
        } elseif (in_array(strtolower($extension), $videoExtensions) && is_file($file)) {
            $data = base64_encode(file_get_contents($file));
            return '<video id="media" controls><source src="data:video/' . $extension . ';base64,' . $data . '" type="video/mp4"></video>';
        } else if (in_array(strtolower($extension), $audioExtensions) && is_file($file)) {
            $data = base64_encode(file_get_contents($file));
            return '<audio id="media" controls><source src="data:audio/' . $extension . ';base64,' . $data . '" type="audio/mp3"></audio>';
        } elseif ($extension === 'txt') {
            $content = file_get_contents($file);
            $formattedContent = htmlentities($content);
            return '<form method="post" action="save.php"><textarea name="content">' . $formattedContent . '</textarea><input type="hidden" name="file" value="' . htmlspecialchars($file) . '"><input type="submit" value="Enregistrer"></form>';
        }
        $content = file_get_contents($file);
        $formattedContent = htmlentities($content);
        return $formattedContent;
    }
}
