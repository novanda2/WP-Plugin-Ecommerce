import Head from 'next/head';
import Link from 'next/link';

// data
import { getAllPosts } from '../../lib/api';

// styles
import styles from '../../styles/Home.module.css';
import blogStyles from '../../styles/Blog.module.css';

export default function Blog({ allPosts: { edges } }) {
    return (
        <div className={styles.container}>
            <Head>
                <title>Blog articles page</title>
                <link rel='icon' href='/favicon.ico' />
            </Head>

            <main className={styles.main}>
                <h1 className={styles.title}>Latest blog articles</h1>
                <hr />
                <section>
                    {edges.map(({ node }) => (
                        <div className={blogStyles.listitem} key={node.id}>
                            <div className={blogStyles.listitem__thumbnail}>
                                <figure>
                                    <img
                                        src={node.featuredImage.node.sourceUrl}
                                        alt={node.title}
                                    />
                                </figure>
                            </div>
                            <div className={blogStyles.listitem__content}>
                                <h2>{node.title}</h2>
                                {/* <p  dangerouslySetInnerHTML={{__html: node.excerpt}}></p> */}
                                <p>imagine this is an awesome excerpt, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi </p>
                                <Link href={`/blog/${node.slug}`}>
                                    <a>Read more </a>
                                </Link>
                            </div>
                        </div>
                    ))}
                </section>
            </main>
        </div>
    )
};

// export default Blog

export async function getStaticProps() {
    const allPosts = await getAllPosts();
    return {
        props: {
            allPosts
        }
    };
}
