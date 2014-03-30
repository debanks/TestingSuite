Testing Suite UI
==============

This testing UI Suite is a general PHP UI for displaying the results of a
testing suite. It reads XML as the output of a test to be extensible to just
about any kind of test. Can execute a PHP script or just grab the XML from any 
external source. 

Example Settings
--------------

```XML
<settings>
    <version>0.8</version>
    <title>Reddit API Checker Example</title>
    <sections>
        <section position="0">
            <name>API</name>
            <description>
                Just an exmaple of a test on an API. Shows how to get XML and execute script if needed.
            </description>
            <location>../tests/redditTest.xml</location>
            <execute>../php/redditTest.xml</execute>
        </section>
    </sections>
    <footer>
        <title>Reddit API Checker</title>
        <links>
            <link>
                <title>Reddit</title>
                <url>http://reddit.com</url>
            </link>
        </links>
    </footer>
</settings>
```

Example Test
-------------

```XML
<result>
    <status>2</status>
    <tests>
        <test status="2">
            <title>Test All Reddits XML</title>
            <description>Checks the reddit API on the All Subreddit and makes sure it matches what I expect.</description>
            <url>http://www.reddit.com/r/all.xml?limit=50</url>
            <table>
                <row>
                    <cell status="2">Had 50 Threads</cell>
                    <cell status="2">Title was as Expected</cell>
                    <cell status="2">Had Expected Description</cell>
                </row>
            </table>
        </test>
    </tests>
</result>
```