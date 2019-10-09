# Kunstmaan API Bundle

See [example/]() for an example implementation

Api layer for [https://github.com/Kunstmaan/KunstmaanBundlesCMS]()

`composer require devigner/kunstmaan-api-bundle`

# How to

## Page
Every Entity that implements `Kunstmaan\NodeBundle\Entity\PageInterface` that needs API exposure needs to:
- Implement `Devigner\KunstmaanApiBundle\Entity\PageModelInterface`.
- Have a model based upon `Devigner\KunstmaanApiBundle\Model\PageEntityInterface`.

## Overview Page
If an overview page is needed (eg Newspage) you need to implement:
`Devigner\KunstmaanApiBundle\Entity\EntityInjectionInterface`

## PagePart
Every Entity that implements `Kunstmaan\PagePartBundle\Helper\PagePartInterface` that needs API exposure needs to:
- Implement `Devigner\KunstmaanApiBundle\Entity\PagePartsModelInterface`.
- Have a model based upon `Devigner\KunstmaanApiBundle\Model\PagePartsEntityInterface`.

# Service

      Devigner\KunstmaanApiBundle\EventListener\SlugEventListener:
        arguments:
          - '%kunstmaan_menu.menus%'
