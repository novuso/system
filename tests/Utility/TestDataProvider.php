<?php declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Test\Resources\TestStringObject;
use Novuso\System\Test\TestCase\VirtualFileSystem;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Trait TestDataProvider
 */
trait TestDataProvider
{
    use VirtualFileSystem;

    public function validScalarProvider()
    {
        return [
            ['string'],
            [3.14],
            [42],
            [true]
        ];
    }

    public function invalidScalarProvider()
    {
        return [
            [null],
            [new \StdClass()]
        ];
    }

    public function validBoolProvider()
    {
        return [
            [true],
            [false]
        ];
    }

    public function invalidBoolProvider()
    {
        return [
            [1],
            [null]
        ];
    }

    public function validFloatProvider()
    {
        return [
            [3.14],
            [-0.000012],
            [1.0]
        ];
    }

    public function invalidFloatProvider()
    {
        return [
            ['3.14'],
            [42]
        ];
    }

    public function validIntProvider()
    {
        return [
            [0],
            [0b101001],
            [0xff],
            [0700],
            [-100]
        ];
    }

    public function invalidIntProvider()
    {
        return [
            ['42'],
            ['101001'],
            [1.0]
        ];
    }

    public function validStringProvider()
    {
        return [
            [''],
            ['foo']
        ];
    }

    public function invalidStringProvider()
    {
        return [
            [null]
        ];
    }

    public function validArrayProvider()
    {
        return [
            [['foo', 'bar', 'baz']],
            [[]]
        ];
    }

    public function invalidArrayProvider()
    {
        return [
            [null],
            [new \ArrayObject()]
        ];
    }

    public function validObjectProvider()
    {
        return [
            [new \StdClass()]
        ];
    }

    public function invalidObjectProvider()
    {
        return [
            [null],
            [[]]
        ];
    }

    public function validCallableProvider()
    {
        return [
            [function () {}],
            ['array_merge'],
            [[new \DateTime(), 'getTimestamp']]
        ];
    }

    public function invalidCallableProvider()
    {
        return [
            [null],
            [new \DateTime()]
        ];
    }

    public function validNullProvider()
    {
        return [
            [null]
        ];
    }

    public function invalidNullProvider()
    {
        return [
            [false],
            ['']
        ];
    }

    public function validNotNullProvider()
    {
        return [
            [false],
            ['']
        ];
    }

    public function invalidNotNullProvider()
    {
        return [
            [null]
        ];
    }

    public function validTrueProvider()
    {
        return [
            [true]
        ];
    }

    public function invalidTrueProvider()
    {
        return [
            [false]
        ];
    }

    public function validFalseProvider()
    {
        return [
            [false]
        ];
    }

    public function invalidFalseProvider()
    {
        return [
            [true]
        ];
    }

    public function validEmptyProvider()
    {
        return [
            [''],
            [0],
            [0.0],
            ['0'],
            [null],
            [false],
            [[]]
        ];
    }

    public function invalidEmptyProvider()
    {
        return [
            [' '],
            [1],
            [1.0],
            ['1'],
            [function () {}],
            [true],
            [[0]],
            [new \ArrayObject()]
        ];
    }

    public function validNotEmptyProvider()
    {
        return [
            [' '],
            [1],
            [1.0],
            ['1'],
            [function () {}],
            [true],
            [[0]],
            [new \ArrayObject()]
        ];
    }

    public function invalidNotEmptyProvider()
    {
        return [
            [''],
            [0],
            [0.0],
            ['0'],
            [null],
            [false],
            [[]]
        ];
    }

    public function validBlankProvider()
    {
        return [
            [null],
            [''],
            [' '],
            [false],
            [new TestStringObject('')]
        ];
    }

    public function invalidBlankProvider()
    {
        return [
            ['value'],
            [true],
            [10],
            [1.17],
            [new TestStringObject('value')],
            [[]]
        ];
    }

    public function validNotBlankProvider()
    {
        return [
            ['value'],
            [true],
            [10],
            [1.17],
            [new TestStringObject('value')]
        ];
    }

    public function invalidNotBlankProvider()
    {
        return [
            [null],
            [''],
            [' '],
            [false],
            [new TestStringObject('')],
            [[]]
        ];
    }

    public function validAlphaProvider()
    {
        return [
            ['YjsZmHXHSxycLlZc'],
            ['uFzzkqBzWalPvztM'],
            ['aBAozPKgQfPIOZhQ'],
            ['kTotDhmqsfIJKxsC']
        ];
    }

    public function invalidAlphaProvider()
    {
        return [
            ['gq4XRHPx3zLqiFYj'],
            ['uAZ25RGjlgwg5kCY'],
            ['6cWxSYr0YWn5Matn'],
            ['G9i6rA87spb1RlEu'],
            [[]]
        ];
    }

    public function validAlnumProvider()
    {
        return [
            ['gq4XRHPx3zLqiFYj'],
            ['uAZ25RGjlgwg5kCY'],
            ['6cWxSYr0YWn5Matn'],
            ['G9i6rA87spb1RlEu']
        ];
    }

    public function invalidAlnumProvider()
    {
        return [
            ['YjzRUhM__Aib_WnQ'],
            ['MRhp-R_AnsQEyBCp'],
            ['kaP-ps_fIn-qibPu'],
            ['Pya-k-Svxf-RgAIN'],
            [[]]
        ];
    }

    public function validAlphaDashProvider()
    {
        return [
            ['YjzRUhM__Aib_WnQ'],
            ['MRhp-R_AnsQEyBCp'],
            ['kaP-ps_fIn-qibPu'],
            ['Pya-k-Svxf-RgAIN']
        ];
    }

    public function invalidAlphaDashProvider()
    {
        return [
            ['Lx7lDu-9oL0u-dsg'],
            ['_7RtK6U1HjU_qk4n'],
            ['C-3geaSMz9ySjm8_'],
            ['fV54_j-1Qheh0Ine'],
            [[]]
        ];
    }

    public function validAlnumDashProvider()
    {
        return [
            ['Lx7lDu-9oL0u-dsg'],
            ['_7RtK6U1HjU_qk4n'],
            ['C-3geaSMz9ySjm8_'],
            ['fV54_j-1Qheh0Ine']
        ];
    }

    public function invalidAlnumDashProvider()
    {
        return [
            ['U&36wu@@FO$vV7zy'],
            ['JBNKxkjs@8VgQFfk'],
            ['d%#3rKh77UFpLrsT'],
            ['jrKh4g^Pldz2aqc#'],
            [[]]
        ];
    }

    public function validDigitsProvider()
    {
        return [
            ['0576707396293939'],
            ['4120922250624932'],
            ['6363135058088673'],
            ['0021057296675399']
        ];
    }

    public function invalidDigitsProvider()
    {
        return [
            ['gq4XRHPx3zLqiFYj'],
            ['uAZ25RGjlgwg5kCY'],
            ['6cWxSYr0YWn5Matn'],
            ['G9i6rA87spb1RlEu'],
            [[]]
        ];
    }

    public function validNumericProvider()
    {
        return [
            [42],
            [3.14],
            [0x446164],
            [0b10001000110000101100100],
            ['42'],
            ['3.14'],
            ['0777'],
            ['+0123.45e6'],
            ['-0123.45e6']
        ];
    }

    public function invalidNumericProvider()
    {
        return [
            ['U&36wu@@FO$vV7zy'],
            ['JBNKxkjs@8VgQFfk'],
            ['d%#3rKh77UFpLrsT'],
            ['jrKh4g^Pldz2aqc#'],
            [[]]
        ];
    }

    public function validEmailProvider()
    {
        return [
            ['email@example.com'],
            ['firstname.lastname@example.com'],
            ['email@subdomain.example.com'],
            ['firstname+lastname@example.com'],
            ['"email"@example.com'],
            ['1234567890@example.com'],
            ['email@example-one.com'],
            ['_______@example.com'],
            ['email@example.name'],
            ['email@example.museum'],
            ['email@example.co.jp']
        ];
    }

    public function invalidEmailProvider()
    {
        return [
            ['plainaddress'],
            ['#@%^%#$@#$@#.com'],
            ['@example.com'],
            ['Joe Smith <email@example.com>'],
            ['email.example.com'],
            ['email@example@example.com'],
            ['.email@example.com'],
            ['email.@example.com'],
            ['email..email@example.com'],
            ['email@example.com (Joe Smith)'],
            ['email@example'],
            ['email@-example.com'],
            ['email@example..com'],
            ['Abc..123@example.com'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validIpAddressProvider()
    {
        return [
            ['155.217.46.237'],
            ['12.177.186.9'],
            ['162.118.58.122'],
            ['138.182.76.252'],
            ['FEDC:BA98:7654:3210:FEDC:BA98:7654:3210'],
            ['1080::8:800:200C:417A'],
            ['FF01::101'],
            ['::1']
        ];
    }

    public function invalidIpAddressProvider()
    {
        return [
            ['155.217.461.237'],
            ['12.177.186.9.1'],
            ['162.118.122'],
            ['138.182.76.257'],
            ['02001:0000:1234:0000:0000:C1C0:ABCD:0876'],
            ['3ffe:0b00:0000:0001:0000:0000:000a'],
            ['3ffe:b00::1::a'],
            ['1111:2222:3333:4444::5555:'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validIpV4AddressProvider()
    {
        return [
            ['155.217.46.237'],
            ['12.177.186.9'],
            ['162.118.58.122'],
            ['138.182.76.252']
        ];
    }

    public function invalidIpV4AddressProvider()
    {
        return [
            ['155.217.461.237'],
            ['12.177.186.9.1'],
            ['162.118.122'],
            ['138.182.76.257'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validIpV6AddressProvider()
    {
        return [
            ['FEDC:BA98:7654:3210:FEDC:BA98:7654:3210'],
            ['1080::8:800:200C:417A'],
            ['FF01::101'],
            ['::1']
        ];
    }

    public function invalidIpV6AddressProvider()
    {
        return [
            ['02001:0000:1234:0000:0000:C1C0:ABCD:0876'],
            ['3ffe:0b00:0000:0001:0000:0000:000a'],
            ['3ffe:b00::1::a'],
            ['1111:2222:3333:4444::5555:'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validUriProvider()
    {
        return [
            ['a:b'],
            ['foo://user@'],
            ['http://www.google.com'],
            ['https://domain.com:10082/foo/bar?query'],
            ['mailto:smith@example.com'],
            ['http://a_.!~*\'(-)U1HYn0%25%26:secret;:&=+$,ddd@www.me.com'],
            ['http://[FEDC:BA98:7654:3210:FEDC:BA98:7654:3210]:80/index.html'],
            ['http://[1080::8:800:200C:417A]/path'],
            ['http://[::192.9.5.5]/ipng'],
            ['http://[::FFFF:129.144.52.38]:80/index.html'],
            ['http://[2620:0:1cfe:face:b00c::3]/'],
            ['http://[vf.some-future+ip]'],
            ['http://foo#frag'],
            ['ftp://user:pass@example.org/'],
            ['http://1.1.1.1/'],
            ['http://[::1]/'],
            ['file:/'],
            ['http:///'],
            ['http:::/foo'],
            ['news:comp.infosystems.www.servers.unix'],
            ['tel:+1-816-555-1212'],
            ['urn:oasis:names:specification:docbook:dtd:xml:4.1.2'],
            ['urn:uuid:f81d4fae-7dec-11d0-a765-00a0c91e6bf6']
        ];
    }

    public function invalidUriProvider()
    {
        return [
            [''],
            ['//missing-scheme'],
            ['https://%@domain/path'],
            ['http://[3ffe:b00::1::a]'],
            ['https://do[main].com'],
            ['http://domain/p%th'],
            ['file:///etc?foo=[a]'],
            ['uri:foo:bar#[baz]'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validUrnProvider()
    {
        return [
            ['urn:cts:greekLit:tlg0012.tlg001.perseus-eng2'],
            ['URN:ISBN:978-1-491-90501-2'],
            ['urn:oasis:names:tc:docbook:dtd:xml:docbook:5.0b1'],
            ['urn:uuid:0977c273-5aac-403b-be23-1a0838e7940a']
        ];
    }

    public function invalidUrnProvider()
    {
        return [
            ['urn:loc.gov:books'],
            ['urn:urn:foo-invalid-namespace'],
            ['urn:example:reserved#characters'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validUuidProvider()
    {
        return [
            ['{5dd64499-0193-4753-8b6e-8286eb2d60b1}'],
            ['urn:uuid:5867eca3-874b-480f-a3a7-c6ea442a032a'],
            ['4df15ab0-d31f-11e4-93ba-765da632ca19'],
            ['014c5243-37e2-4463-a6b1-32a986565d19'],
            ['f18543a1-2b6d-36a5-b229-90c8fec28a35'],
            ['b2e4bc61-8cd1-5a49-b154-a449e6165f13']
        ];
    }

    public function invalidUuidProvider()
    {
        return [
            ['{5dd64499-0193-4753-8b6e82-86eb2d60b1}'],
            ['urn:uuid:5867eca3-874b-480f-a3a7-c6ea442a032'],
            ['4df15ab0-d31f-11e4-93ba-765dg632ca19'],
            ['014c5243-37e2-44-63-a6b1-32a986565d19'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validTimezoneProvider()
    {
        return [
            ['America/Chicago'],
            ['America/Jamaica'],
            ['Europe/Madrid'],
            ['Pacific/Pago_Pago']
        ];
    }

    public function invalidTimezoneProvider()
    {
        return [
            [new \DateTimeZone('+00:00')],
            ['America/San_Antonio'],
            ['America/Tiajuana'],
            ['Central'],
            ['United'],
            ['Asia/Bollywood'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validJsonProvider()
    {
        return [
            ['null'],
            ['{"foo":"bar"}'],
            ['["list","of","items"]']
        ];
    }

    public function invalidJsonProvider()
    {
        return [
            ['["list","of",'],
            [[]]
        ];
    }

    public function validMatchProvider()
    {
        return [
            [
                'f81d4fae-7dec-11d0-a765-00a0c91e6bf6',
                '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i'
            ],
            [
                'https://www.google.com/search?client=ubuntu&channel=fs&q=regular+expressions&ie=utf-8&oe=utf-8',
                '/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?$/'
            ],
            [
                '192.168.0.1',
                '/^(?:(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])\.){3}(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])$/'
            ]
        ];
    }

    public function invalidMatchProvider()
    {
        return [
            [
                'f81d4fae-7dec-11d0-a76500-a0c91e6bf6',
                '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i'
            ],
            [
                'https://www.google.com/search?client=ubuntu&channel=fs&q=regular+expressions&ie=utf-8&oe=utf-8',
                '/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))$/'
            ],
            [
                '192.168.000.001',
                '/^(?:(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])\.){3}(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])$/'
            ],
            [
                [],
                '/.*/'
            ]
        ];
    }

    public function validContainsProvider()
    {
        return [
            ['services@example.com', 'example'],
            ['https://www.google.com', '://'],
            ['file:///etc/hosts', '///']
        ];
    }

    public function invalidContainsProvider()
    {
        return [
            ['services@example.com', 'google'],
            ['https://www.google.com', '::'],
            ['file:///etc/hosts', 'www'],
            [[], 'array']
        ];
    }

    public function validStartsWithProvider()
    {
        return [
            ['services@example.com', 'services'],
            ['https://www.google.com', 'https:'],
            ['file:///etc/hosts', 'file:']
        ];
    }

    public function invalidStartsWithProvider()
    {
        return [
            ['services@example.com', 'admin'],
            ['https://www.google.com', 'http:'],
            ['file:///etc/hosts', '/'],
            [[], 'array']
        ];
    }

    public function validEndsWithProvider()
    {
        return [
            ['services@example.com', 'example.com'],
            ['https://www.google.com', 'google.com'],
            ['file:///etc/hosts', 'hosts']
        ];
    }

    public function invalidEndsWithProvider()
    {
        return [
            ['services@example.com', 'example.org'],
            ['https://www.google.com', 'yahoo.com'],
            ['file:///etc/hosts', 'interfaces'],
            [[], 'array']
        ];
    }

    public function validExactLengthProvider()
    {
        return [
            ['hello world', 11]
        ];
    }

    public function invalidExactLengthProvider()
    {
        return [
            ['hello world!', 11],
            [[], 2],
            [new \ArrayObject(), 0]
        ];
    }

    public function validMinLengthProvider()
    {
        return [
            ['hello', 2],
            ['hello', 5]
        ];
    }

    public function invalidMinLengthProvider()
    {
        return [
            ['hello', 6],
            [[], 0],
            [new \ArrayObject(), 0]
        ];
    }

    public function validMaxLengthProvider()
    {
        return [
            ['hello', 10],
            ['hello', 5]
        ];
    }

    public function invalidMaxLengthProvider()
    {
        return [
            ['hello', 2],
            [[], 100],
            [new \ArrayObject(), 100]
        ];
    }

    public function validRangeLengthProvider()
    {
        return [
            ['hello', 5, 10],
            ['hello', 2, 5],
            ['hello', 1, 10]
        ];
    }

    public function invalidRangeLengthProvider()
    {
        return [
            ['hello', 6, 20],
            ['hello', 2, 3],
            [[], 0, 100],
            [new \ArrayObject(), 0, 100]
        ];
    }

    public function validExactNumberProvider()
    {
        return [
            ['42', 42],
            ['3.14', 3.14],
            ['17.0', 17],
            [42, 42],
            [3.14, 3.14],
            [17.0, 17]
        ];
    }

    public function invalidExactNumberProvider()
    {
        return [
            ['42.1', 42],
            ['apples', 12],
            [[], 0],
            [new \ArrayObject(), 0]
        ];
    }

    public function validMinNumberProvider()
    {
        return [
            ['42', 42],
            ['3.14', 3.14],
            ['17.0', 17],
            [42, 20],
            [3.14, 3],
            [17.0, 7]
        ];
    }

    public function invalidMinNumberProvider()
    {
        return [
            ['42.1', 50],
            ['apples', 12],
            [[], 0],
            [new \ArrayObject(), 0]
        ];
    }

    public function validMaxNumberProvider()
    {
        return [
            ['42', 42],
            ['3.14', 3.14],
            ['17.0', 17],
            [42, 50],
            [3.14, 5],
            [17.0, 20]
        ];
    }

    public function invalidMaxNumberProvider()
    {
        return [
            ['42.1', 40],
            ['apples', 12],
            [[], 100],
            [new \ArrayObject(), 100]
        ];
    }

    public function validRangeNumberProvider()
    {
        return [
            ['42', 40, 42],
            ['3.14', 3.14, 4],
            ['17.0', 15, 20],
            [42, 40, 50],
            [3.14, 2, 5],
            [17.0, 10, 20]
        ];
    }

    public function invalidRangeNumberProvider()
    {
        return [
            ['42.1', 20, 30],
            ['17.3', 20, 30],
            ['apples', 1, 12],
            [[], 0, 100],
            [new \ArrayObject(), 0, 100]
        ];
    }

    public function validWholeNumberProvider()
    {
        return [
            ['42'],
            [42],
            ['7.0'],
            [1.0],
            ['0']
        ];
    }

    public function invalidWholeNumberProvider()
    {
        return [
            ['-17'],
            [-1],
            ['3.14'],
            ['apples'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validNaturalNumberProvider()
    {
        return [
            ['42'],
            [42],
            ['7.0'],
            [1.0]
        ];
    }

    public function invalidNaturalNumberProvider()
    {
        return [
            ['-17'],
            [0],
            ['3.14'],
            ['apples'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validIntValueProvider()
    {
        return [
            ['42'],
            [42],
            ['7.0'],
            [1.0],
            ['0']
        ];
    }

    public function invalidIntValueProvider()
    {
        return [
            ['-17.01'],
            [0.1],
            ['3.14'],
            ['apples'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validExactCountProvider()
    {
        return [
            [['one', 'two', 'three'], 3],
            [['foo', 'bar'], 2]
        ];
    }

    public function invalidExactCountProvider()
    {
        return [
            [['one', 'two', 'three'], 2],
            ['foo', 2]
        ];
    }

    public function validMinCountProvider()
    {
        return [
            [['one', 'two', 'three'], 3],
            [['foo', 'bar'], 1]
        ];
    }

    public function invalidMinCountProvider()
    {
        return [
            [['one', 'two', 'three'], 4],
            ['foo', 1]
        ];
    }

    public function validMaxCountProvider()
    {
        return [
            [['one', 'two', 'three'], 3],
            [['foo', 'bar'], 3]
        ];
    }

    public function invalidMaxCountProvider()
    {
        return [
            [['one', 'two', 'three'], 2],
            ['foo', 1]
        ];
    }

    public function validRangeCountProvider()
    {
        return [
            [['one', 'two', 'three'], 1, 3],
            [['foo', 'bar'], 0, 5]
        ];
    }

    public function invalidRangeCountProvider()
    {
        return [
            [['one', 'two', 'three'], 10, 20],
            [['one', 'two', 'three'], 0, 2],
            ['foo', 1, 5]
        ];
    }

    public function validOneOfProvider()
    {
        return [
            ['bar', ['foo', 'bar', 'baz']]
        ];
    }

    public function invalidOneOfProvider()
    {
        return [
            ['buz', ['foo', 'bar', 'baz']]
        ];
    }

    public function validKeyIssetProvider()
    {
        return [
            [['foo' => 'bar'], 'foo'],
            [['foo' => ''], 'foo']
        ];
    }

    public function invalidKeyIssetProvider()
    {
        return [
            [['foo' => null], 'foo'],
            ['bar', 'foo']
        ];
    }

    public function validKeyNotEmptyProvider()
    {
        return [
            [['foo' => 'bar'], 'foo'],
            [['foo' => ['one']], 'foo']
        ];
    }

    public function invalidKeyNotEmptyProvider()
    {
        return [
            [['foo' => ''], 'foo'],
            ['bar', 'foo']
        ];
    }

    public function validEqualProvider()
    {
        return [
            [42, '42'],
            [3.14, '3.14'],
            [0, false],
            ['', null],
            [1, true],
            [new TestStringObject('hello'), new TestStringObject('hello')]
        ];
    }

    public function invalidEqualProvider()
    {
        return [
            [41, '42'],
            [3.14, '3.17'],
            ['1', false],
            [new \StdClass(), null],
            [0, true],
            [new TestStringObject('hello'), new TestStringObject('Hello')]
        ];
    }

    public function validNotEqualProvider()
    {
        return [
            [41, '42'],
            [3.14, '3.17'],
            ['1', false],
            [new \StdClass(), null],
            [0, true],
            [new TestStringObject('hello'), new TestStringObject('Hello')]
        ];
    }

    public function invalidNotEqualProvider()
    {
        return [
            [42, '42'],
            [3.14, '3.14'],
            [0, false],
            ['', null],
            [1, true],
            [new TestStringObject('hello'), new TestStringObject('hello')]
        ];
    }

    public function validSameProvider()
    {
        $obj = new \StdClass();

        return [
            [$obj, $obj],
            [[], []],
            [42, 42],
            [3.14, 3.14]
        ];
    }

    public function invalidSameProvider()
    {
        return [
            [new \StdClass(), new \StdClass()],
            [42, '42'],
            [3.14, '3.14'],
            [1, true]
        ];
    }

    public function validNotSameProvider()
    {
        return [
            [new \StdClass(), new \StdClass()],
            [42, '42'],
            [3.14, '3.14'],
            [1, true]
        ];
    }

    public function invalidNotSameProvider()
    {
        $obj = new \StdClass();

        return [
            [$obj, $obj],
            [[], []],
            [42, 42],
            [3.14, 3.14]
        ];
    }

    public function validSameTypeProvider()
    {
        return [
            [new \StdClass(), new \StdClass()],
            [42, 17],
            [3.17, 1.119],
            ['foo', 'bar']
        ];
    }

    public function invalidSameTypeProvider()
    {
        return [
            [new \StdClass(), new \DateTime()],
            [42, 3.17],
            [17, 1.119],
            ['foo', true]
        ];
    }

    public function validTypeProvider()
    {
        return [
            ['hello', 'string'],
            [true, 'bool'],
            [3.14, 'float'],
            [17, 'int'],
            [42, 'int'],
            [['foo'], 'array'],
            [function () {}, 'callable'],
            ['42', 'string'],
            [new \StdClass(), 'object'],
            [123.456, 'float'],
            [new \DateTime(), 'DateTime'],
            [['anything'], null]
        ];
    }

    public function invalidTypeProvider()
    {
        return [
            ['hello', 'bool'],
            [true, 'float'],
            [3.14, 'int'],
            [17, 'double'],
            [42, 'array'],
            [['foo'], 'callable'],
            [function () {}, 'numeric'],
            ['42', 'object'],
            [new \StdClass(), 'scalar'],
            [123.456, 'DateTime'],
            [new \DateTime(), 'string']
        ];
    }

    public function validListOfProvider()
    {
        return [
            [['foo', 'bar', 'baz'], 'string'],
            [[1, 2, 3], 'int'],
            [[new \DateTime(), new \DateTime()], 'DateTime'],
            [['foo', 1, 3.14], null]
        ];
    }

    public function invalidListOfProvider()
    {
        return [
            [['foo', 'bar', 'baz'], 'DateTime'],
            [[1, 2, 3], 'string'],
            [[new \DateTime(), new \DateTime()], 'int'],
            ['foo', 'bar']
        ];
    }

    public function validStringCastableProvider()
    {
        return [
            ['hello'],
            [null],
            [true],
            [42],
            [3.14],
            [new TestStringObject('hello')]
        ];
    }

    public function invalidStringCastableProvider()
    {
        return [
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validJsonEncodableProvider()
    {
        return [
            [null],
            ['foo'],
            [['foo' => 'bar']],
            [new TestStringObject('hello')]
        ];
    }

    public function invalidJsonEncodableProvider()
    {
        $string = 'Hello World';
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $string);
        rewind($stream);

        return [
            [$stream],
            [['stream' => $stream]],
            [['number' => INF]]
        ];
    }

    public function validTraversableProvider()
    {
        return [
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function invalidTraversableProvider()
    {
        return [
            ['foo'],
            [new \DateTime()]
        ];
    }

    public function validCountableProvider()
    {
        return [
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function invalidCountableProvider()
    {
        return [
            ['foo'],
            [new \DateTime()]
        ];
    }

    public function validArrayAccessibleProvider()
    {
        return [
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function invalidArrayAccessibleProvider()
    {
        return [
            ['foo'],
            [new \DateTime()]
        ];
    }

    public function validComparableProvider()
    {
        return [
            [new TestStringObject('foo')]
        ];
    }

    public function invalidComparableProvider()
    {
        return [
            [new \DateTime()]
        ];
    }

    public function validEquatableProvider()
    {
        return [
            [new TestStringObject('foo')]
        ];
    }

    public function invalidEquatableProvider()
    {
        return [
            [new \DateTime()]
        ];
    }

    public function validImplementsProvider()
    {
        return [
            [new \DateTime(), 'DateTimeInterface'],
            ['DateTime', 'DateTimeInterface'],
            ['Iterator', 'Traversable']
        ];
    }

    public function invalidImplementsProvider()
    {
        return [
            [new \ArrayObject(), 'DateTimeInterface'],
            ['ArrayObject', 'DateTimeInterface'],
            ['Foobarbazbuz', 'DateTimeInterface']
        ];
    }

    public function validInstanceOfProvider()
    {
        return [
            [new \DateTime(), 'DateTime'],
            [new \DateTime(), 'DateTimeInterface']
        ];
    }

    public function invalidInstanceOfProvider()
    {
        return [
            [new \ArrayObject(), 'DateTimeInterface'],
            ['ArrayObject', 'ArrayObject']
        ];
    }

    public function validSubclassOfProvider()
    {
        return [
            [new \SplQueue(), 'SplDoublyLinkedList'],
            ['SplQueue', 'SplDoublyLinkedList'],
            ['DateTime', 'DateTimeInterface']
        ];
    }

    public function invalidSubclassOfProvider()
    {
        return [
            [new \ArrayObject(), 'DateTimeInterface'],
            ['DateTime', 'DateTime']
        ];
    }

    public function validClassExistsProvider()
    {
        return [
            ['DateTime']
        ];
    }

    public function invalidClassExistsProvider()
    {
        return [
            ['Foobarbazbuz'],
            [[]]
        ];
    }

    public function validInterfaceExistsProvider()
    {
        return [
            ['Iterator']
        ];
    }

    public function invalidInterfaceExistsProvider()
    {
        return [
            ['Foobarbazbuz'],
            [[]]
        ];
    }

    public function validMethodExistsProvider()
    {
        return [
            ['format', new \DateTime()],
            ['format', 'DateTime']
        ];
    }

    public function invalidMethodExistsProvider()
    {
        return [
            ['foobar', new \DateTime()],
            [[], 'DateTime']
        ];
    }

    public function validPathProvider()
    {
        return [
            ['vfs://root/app/config'],
            ['vfs://root/app/config/parameters.yml'],
            ['vfs://root/app/cache/container.php']
        ];
    }

    public function invalidPathProvider()
    {
        return [
            ['vfs://root/app/config/local.yml'],
            ['vfs://root/app/storage'],
            [[]]
        ];
    }

    public function validFileProvider()
    {
        return [
            ['vfs://root/app/config/config.yml'],
            ['vfs://root/app/config/parameters.yml'],
            ['vfs://root/app/cache/container.php']
        ];
    }

    public function invalidFileProvider()
    {
        return [
            ['vfs://root/app/config/local.yml'],
            ['vfs://root/app/config/secret.yml'],
            [[]]
        ];
    }

    public function validDirProvider()
    {
        return [
            ['vfs://root/app/config'],
            ['vfs://root/app/cache']
        ];
    }

    public function invalidDirProvider()
    {
        return [
            ['vfs://root/app/storage'],
            [[]]
        ];
    }

    public function validReadableProvider()
    {
        return [
            ['vfs://root/app/config/config.yml'],
            ['vfs://root/app/config']
        ];
    }

    public function invalidReadableProvider()
    {
        return [
            [[]]
        ];
    }

    public function validWritableProvider()
    {
        return [
            ['vfs://root/app/cache/container.php'],
            ['vfs://root/app/cache']
        ];
    }

    public function invalidWritableProvider()
    {
        return [
            [[]]
        ];
    }

    protected function createFilesystem()
    {
        $vfs = $this->createVfs([
            'app' => [
                'config' => [
                    'config.yml'     => 'foo: bar',
                    'parameters.yml' => 'secret: password'
                ],
                'cache'  => [
                    'container.php' => "<?php\n\nclass Container\n{\n}\n"
                ]
            ]
        ]);
        /** @var vfsStreamDirectory $appDir */
        $appDir = $vfs->getChild('app');
        /** @var vfsStreamDirectory $configDir */
        $configDir = $appDir->getChild('config');
        $configDir->chown(vfsStream::OWNER_ROOT);
        $configDir->chmod(0755);
        $config = $configDir->getChild('config.yml');
        $config->chown(vfsStream::OWNER_ROOT);
        $config->chmod(0644);
        $parameters = $configDir->getChild('parameters.yml');
        $parameters->chown(vfsStream::OWNER_ROOT);
        $parameters->chmod(0600);
    }
}
