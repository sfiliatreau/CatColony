<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--
        Sarah Howard
        CSC 235
        readMe.php
        2022 Spring B
        -->

    <title>CatColony | ReadMe</title>

    <meta name="description" content="ReadMe file for Sarah Howard's CSC 235 term project: CatColony">
    <meta name=" viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/style.css">

</head>


<body>
    <!-- skip navigation link -->
    <a id="skipNav" href="#mainContent">Skip to main content</a>

    <div id="pageContainer">

        <header>
            <h2>CatColony</h2>
        </header>

        <!-- Start main HTML chunk -->
        <main id="mainContent">

            <h1>CatColony ReadMe</h1>

            <h2>Introduction</h2>

            <p><a href="index.php" target="_blank">CatColony</a> is a site dedicated to helping neighborhood cat people track the activity and health of local feral cat colonies. The site will allow users to identify cats, log and track their movements, and log and track health information such as spay/neuter status, vaccinations, or injuries. The site will also offer the ability to contribute cute photos and videos of the cats, because excluding this feature would be inexcusable.</p>
            <p>Initial development will focus on tracking a single known colony with some moderator/administrator oversight required. Later development phases will expand into more social/community editing capabilities, and the ability to track multiple colonies or independent feral cats.</p>
           
           
            <h2>Development timeline</h2>
            
            <h3>Phase 1: Track a known colony</h3>
            <p>Timeframe: Span of CSC 235</p>
            <p>Goals:</p>
            <ul>
                <li>Establish initial database structure</li>
                <li>Establish initial site layout</li>
                <li>Create features based on the following requirements list</li>
            </ul>
            <p>Requirements:</p>
            <ul>
                <li>Page for every individual known cat
                    <ul>
                        <li>Page should include photo/photos</li>
                        <li>Identifying markings or attributes</li>
                        <li>Medical history of cat
                            <ul>
                                <li>Age</li>
                                <li>Spay/Neuter status</li>
                                <li>Ongoing medical issues</li>
                                <li>Past medical issues</li>
                            </ul>
                        </li>
                        <li>Other observations
                            <ul>
                                <li>Associated cats</li>
                                <li>Behaviors</li>
                            </ul>
                        </li>
                        <li>Page or area for missing in action cats
                            <ul>
                                <li>Could populate automatically based on time since last logged sighting</li>
                                <li>Or could populate based on manual flags</li>
                                <li>Not on ERD yet, debating structure</li>
                            </ul>
                        </li>
                        <li>BOLO area for cats who need attention or capture (not on ERD yet, debating structure)</li>
                        <li>Place to log info about new cats trying to join the colony</li>
                        <li>Place to log when a cat passes</li>
                    </ul>
                </li>
            </ul>
            <p>Nice to haves</p>
            <ul>
                <li>Care signups where people could commit to certain care tasks
                    <ul>
                        <li>Spay/neuter</li>
                        <li>Feeding</li>
                        <li>Winter warmth</li>
                    </ul>
                </li>
                <li>Place to put just for fun photos and videos etc.</li>
            </ul>
            <p>Must not have</p>
            <ul>
                <li>Must not create a bunch of duplicate profiles for cats</li>
            </ul>
           
            <h3>Phase 2 &ndash; Connect and share</h3>
            <p>Timeframe: TBD, possibly within CSC 235 or afterwards. I will know more once I get further into the project and the curriculum for CSC 235</p>
            <p>Goals:</p>
            <ul>
                <li>Establish authentication</li>
                <li>Allow for user profiles with two permission sets (community user and moderator)</li>
                <li>Create forums</li>
            </ul>
           
            <h3>Phase 3 &ndash; Expand to additional animals and colonies</h3>
            <p>Timeframe: TBD</p>
            <p>Goals: TBD</p>

            
            <h2>Wireframe</h2>
                <img src="graphic/layout.png" alt="wireframe">

            <h2>ERD</h2>
                <img src="graphic/database.png" alt="ERD">


        </main>

        <footer>
            <p><small>Sarah Howard | CSC 235 | CatColony Term Project | Fall B 2021</small></p>
        </footer>

    </div>

</body>

</html>