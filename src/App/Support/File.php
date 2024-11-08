<?php

namespace App\Support;

class File
{
    private $mimeTypes = ['image/jpeg','image/jpg','image/svg', 'pdf','image/png'];

    protected string $error ;
    public function __construct(
        private array $file,

    ){}

    public function getMessage()
    {
        return $this->error;
    }

    public function validate(
    ): bool {

        if(!$this->validateFileExist()){
            return false;
        }


        if(!$this->validateMimetypes()) {
            return false;
        }
 
        if(!$this->validateSize()){
            return false;
        }
        

        return true;

    }

    private function validateFileExist(): bool
    {
        if(!isset($this->file['photo']) || empty($this->file['photo']->getSize())) {
            $this->error = 'Arquivo não encontrado.';
            return false;
        }

        return true ;
    }

    private function validateSize()
    {
        if($this->file['photo']->getSize() > 400000){
            $this->error = 'Excedido tamanho máximo permitido.';
            return false;
        }
        return true;
    }

    private function validateMimetypes(
    ): bool {
        $finfo = new \finfo(
            FILEINFO_MIME_TYPE
        );
        
        $mimeTypeFile = $finfo->file($_FILES['photo']['tmp_name']);

        if(!in_array($mimeTypeFile, $this->mimeTypes)
          || !str_starts_with($mimeTypeFile, 'image/') ) {
            $this->error = 'O tipo de arquivo não é permitido.';
            return false;
        }
        return true;
    }

    public function save()
    {
        
        $safeFileName = uniqid('upload_').'_'.pathinfo(
            $_FILES['photo']['name'],
            PATHINFO_BASENAME
        );

        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            __DIR__.'/../../storage/file/'.$safeFileName
        );

        $this->error = 'Imagem cadastrada com sucesso!';
 
    }
}