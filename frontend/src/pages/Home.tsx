import React from 'react'
import { Link } from 'react-router-dom'
import { ArrowRight, Code, Palette, Zap } from 'lucide-react'

const Home: React.FC = () => {
  const features = [
    {
      icon: Code,
      title: 'Full-Stack Development',
      description: 'Building complete web applications with Laravel backend and modern frontend technologies, containerized with Docker.',
    },
    {
      icon: Palette,
      title: 'Homelab Management',
      description: 'Operating a Proxmox-based homelab environment hosting various self-hosted services including this website, all orchestrated with Docker containers.',
    },
    {
      icon: Zap,
      title: 'Performance Optimization',
      description: 'Leveraging Laravel\'s performance features and Docker\'s scalability to create efficient applications that grow with your needs.',
    },
  ]

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="bg-gradient-to-br from-primary-50 to-white py-20 lg:py-32">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <h1 className="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 animate-fade-in">
              Hi, I'm{' '}
              <span className="text-primary-600">Artur Ferreira</span>
            </h1>
            <p className="text-xl sm:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto animate-slide-up text-balance">
              Full-stack developer and apprentice application developer completing my training in 2027. 
              Passionate about Laravel and Docker, I run a personal homelab with Proxmox where this entire website and other containerized services are hosted.
            </p>
            <div className="flex flex-col sm:flex-row items-center justify-center gap-4 animate-slide-up">
              <Link
                to="/projects"
                className="btn-primary text-lg px-8 py-3 group"
              >
                View My Work
                <ArrowRight className="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform" />
              </Link>
              <a
                href="mailto:artur@ferreiracruz.com"
                className="btn-outline text-lg px-8 py-3"
              >
                Get In Touch
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
              What I Do
            </h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              I specialize in full-stack development with Laravel and Docker while learning the craft through 
              my apprenticeship program. My containerized homelab serves as my personal playground for 
              experimenting with new technologies and deployment strategies.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {features.map((feature, index) => (
              <div
                key={feature.title}
                className="text-center group hover:scale-105 transition-transform duration-300"
                style={{ animationDelay: `${index * 0.1}s` }}
              >
                <div className="inline-flex items-center justify-center w-16 h-16 bg-primary-100 text-primary-600 rounded-full mb-6 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                  <feature.icon className="h-8 w-8" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900 mb-4">
                  {feature.title}
                </h3>
                <p className="text-gray-600 leading-relaxed">
                  {feature.description}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-gray-900 text-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl sm:text-4xl font-bold mb-4">
            Ready to Work Together?
          </h2>
          <p className="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
            Although I'm still in my apprenticeship program until 2027, I'm eager to collaborate 
            on interesting Laravel and Docker-based projects and expand my skills through real-world challenges.
          </p>
          <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
            <Link
              to="/projects"
              className="btn-primary bg-white text-gray-900 hover:bg-gray-100 text-lg px-8 py-3"
            >
              View Portfolio
            </Link>
            <a
              href="mailto:artur@ferreiracruz.com"
              className="btn-outline border-white text-white hover:bg-white hover:text-gray-900 text-lg px-8 py-3"
            >
              Contact Me
            </a>
          </div>
        </div>
      </section>
    </div>
  )
}

export default Home