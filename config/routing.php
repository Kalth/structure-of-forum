<?php

return [
  'accueil' => [
    'controller' => 'forum',
    'get' => [
      'ajax' => [
        'size' => 5,
        'type' => 'bool',
        'optionel' => '',
        ],
      ],
    'method' => 'GET',
  ],
  'topics' => [
  	'controller' => 'forum',
    'get' => [
      'ajax' => [
        'size' => 5,
        'type' => 'bool'
        ],
      'targetId' => [
        'size' => 11,
        'type' => 'int'
        ],
      'cateName' => [
       'size' => 50,
       'type' => 'string'
        ],
      ],
    'method' => 'GET',
  ],
  'inTopic' => [
  	'controller' => 'forum',
    'get' => [
      'ajax' => [
        'size' => 5,
        'type' => 'bool'
        ],
      'targetId' => [
        'size' => 11,
        'type' => 'int'
        ],
      'cateName' => [
       'size' => 50,
       'type' => 'string'
        ],
      ],
    'method' => 'GET',
  ],
  'answer' => [
  	'controller' => 'forum',
    'post' => [
      'msg' => [
        'size' => 6000,
        'type' => 'string',
        ],
      'topic' => [
        'size' => 11,
        'type' => 'int',
        ],
      'location' => [
        'size' => 2000,
        'type' => 'url',
        ],
      ],
    'method' => 'POST',
  ],
  'newTopicPage' => [
    'controller' => 'forum',
    'get' => [
      'ajax' => [
        'size' => 5,
        'type' => 'bool'
        ],
      'cateId' => [
        'size' => 11,
        'type' => 'int'
        ],
      'cateName' => [
       'size' => 50,
       'type' => 'string'
        ],
      ],
    'method' => 'GET',
  ],
  'newTopic' => [
    'controller' => 'forum',
    'post' => [
      'msg' => [
        'size' => 6000,
        'type' => 'string',
      ],
      'titre' => [
        'size' => 50,
        'type' => 'string',
        ],
      'cateId' => [
        'size' => 11,
        'type' => 'int',
        ],
      ],
    'method' => 'POST',
  ],
  'signInPage' => [
    'controller' => 'user',
    'get' => [
      'ajax' => [
        'size' => 5,
        'type' => 'bool'
        ],
      ],
    'method' => 'GET',
  ],
  'signIn' => [
    'controller' => 'user',
    'post' => [
      'identifiant' => [
        'size' => 50,
        'type' => 'string',
      ],
      'pseudo' => [
        'size' => 50,
        'type' => 'string',
      ],
      'password' => [
        'size' => 50,
        'type' => 'string',
      ],
      'password2' => [
        'size' => 50,
        'type' => 'string',
      ],
      'mail' => [
        'size' => 254,
        'type' => 'string',
      ],
    ],
    'method' => 'POST',
  ],
  'logIn' => [
    'controller' => 'user',
    'post' => [
      'identifiant' => [
        'size' => 50,
        'type' => 'string',
      ],
      'password' => [
        'size' => 50,
        'type' => 'string',
      ],
      'location' => [
        'size' => 2000,
        'type' => 'url',
      ],
    ],
    'method' => 'POST',
  ],
  'logOut' => [
    'controller' => 'user',
    'method' => 'GET',
  ],
];
